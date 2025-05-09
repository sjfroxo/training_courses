@extends('layouts.app')

@section('main')
    <div class="w-100 p-4">
        <div class="row">
            <div class="col-md-4 border-end">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Чаты</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChatModal">
                        Создать чат
                    </button>
                </div>
                <input type="search" class="form-control mb-3" placeholder="Поиск">
                <div id="chat-list" class="list-group">
                    @forelse($chats as $chat)
                        <button class="list-group-item list-group-item-action text-start px-2 py-2"
                                data-chat-slug="{{ $chat->slug }}"
                                data-chat-id="{{ $chat->id }}">
                            <div class="fw-bold">
                                @if($chat->users->count() === 1 && $chat->users->first()->id === $user->id)
                                    Избранное
                                @else
                                    {{ $chat->users->where('id', '!=', $user->id)->first()->name ?? 'Избранное' }}
                                @endif
                            </div>
                            <small class="text-muted last-message"
                                   data-message-id="{{ $chat->lastMessage()?->id ?? '' }}">
                                {{ $chat->lastMessage()?->message ?? 'Начните общение!' }}
                            </small>
                        </button>
                    @empty
                        <div class="text-muted">Чатов пока нет.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-md-8" id="chat-details">
                <div class="text-muted">Выберите чат слева</div>
            </div>
        </div>
    </div>
    @include('chats.create-chat')
@endsection

@section('scripts')
    <div id="context-menu" class="position-absolute bg-white border rounded shadow-sm p-2 d-none"
         style="z-index: 1050;">
        <button class="dropdown-item" id="edit-msg">Редактировать</button>
        <button class="dropdown-item text-danger" id="delete-msg">Удалить</button>
    </div>
    <style>
        .my-msg {
            background-color: #c6fff7;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .other-msg {
            background-color: #ececec;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
    </style>
    <script>
        let currentMessageEl = null;
        let currentMessageId = null;

        document.addEventListener('contextmenu', function (e) {
            const msgEl = e.target.closest('.chat-message');
            if (msgEl) {
                e.preventDefault();
                currentMessageEl = msgEl;
                currentMessageId = msgEl.dataset.id;
                const menu = document.getElementById('context-menu');
                menu.style.top = `${e.pageY}px`;
                menu.style.left = `${e.pageX}px`;
                menu.classList.remove('d-none');
            } else {
                document.getElementById('context-menu').classList.add('d-none');
            }
        });

        document.addEventListener('click', function () {
            document.getElementById('context-menu').classList.add('d-none');
        });

        document.getElementById('delete-msg')?.addEventListener('click', async () => {
            if (!currentMessageEl || !currentMessageId) return;

            try {
                const res = await fetch(`/chat/message/${currentMessageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) throw new Error('Failed to delete message');
                currentMessageEl.remove();
                document.getElementById('context-menu').classList.add('d-none');
            } catch (err) {
                console.error('Delete error:', err);
            }
        });

        document.getElementById('edit-msg')?.addEventListener('click', async () => {
            if (!currentMessageEl || !currentMessageId) return;
            const originalText = currentMessageEl.querySelector('.msg-text')?.innerText || '';
            const input = prompt('Редактировать сообщение:', originalText);
            if (input === null || input === originalText) return;

            try {
                const res = await fetch(`/chat/message/${currentMessageId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({message: input})
                });
                if (!res.ok) throw new Error('Failed to edit message');
                const json = await res.json();
                currentMessageEl.querySelector('.msg-text').textContent = json.data.message;
                document.getElementById('context-menu').classList.add('d-none');
            } catch (err) {
                console.error('Edit error:', err);
            }
        });

        function subscribeToChannel(chatId) {
            if (!chatId || !window.Echo) {
                console.error('Cannot subscribe: chatId or Echo is missing', { chatId, echo: window.Echo });
                return;
            }
            const channelName = `private-chat.${chatId}`;
            const channel = window.Echo.connector.pusher.subscribe(channelName);

            channel.bind('MessageSent', (data) => {
                console.log('MessageSent event received:', data);
                const myId = Number(document.body.dataset.myId) || 0;
                if (!data.hasOwnProperty('user_id') || Number(data.user_id) === myId) {
                    console.log('Ignoring message (own or missing user_id):', { data, myId });
                    return;
                }
                const messagesContainer = document.getElementById('messages');
                if (messagesContainer && messagesContainer.dataset.chatId === chatId.toString()) {
                    renderMessage(data);
                    scrollDown();
                }
                const chatBtn = document.querySelector(`[data-chat-id="${chatId}"]`);
                if (chatBtn) {
                    const lastMessageEl = chatBtn.querySelector('.last-message');
                    if (lastMessageEl) {
                        lastMessageEl.textContent = data.message || 'Сообщение';
                        lastMessageEl.dataset.messageId = data.id || '';
                    }
                }
            });

            channel.bind('MessageDeleted', (data) => {
                console.log('MessageDeleted received:', data);
                const el = document.querySelector(`.chat-message[data-id="${data.messageId}"]`);
                if (el) el.remove();
            });

            channel.bind('MessageUpdated', (data) => {
                console.log('MessageUpdated received:', data);
                const el = document.querySelector(`.chat-message[data-id="${data.message.id}"]`);
                if (el) el.querySelector('.msg-text').textContent = data.message.message || '';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.body.dataset.myId = '{{ $user->id }}';
            document.querySelectorAll('[data-chat-id]').forEach(btn => {
                console.log('Subscribing to chat:', btn.dataset.chatId);
                subscribeToChannel(btn.dataset.chatId);
            });
        });

        let loading = false;
        let isLoadingOlderMessages = false;

        function renderMessage(msg, prepend = false) {
            const myId = Number(document.body.dataset.myId) || 0;
            console.log('Rendering message:', { msg, myId });
            const mine = msg.hasOwnProperty('user_id') && msg.user_id ? Number(msg.user_id) === myId : false;
            console.log('Is mine:', mine, 'user_id:', msg.user_id, 'myId:', myId);
            const align = mine ? 'justify-content-end' : 'justify-content-start';
            const cls = mine ? 'my-msg' : 'other-msg';

            const wrap = document.createElement('div');
            wrap.className = `d-flex mb-2 ${align} chat-message`;
            wrap.dataset.id = msg.id;

            const bubble = document.createElement('div');
            bubble.className = `p-2 rounded ${cls}`;
            bubble.style.maxWidth = '70%';
            bubble.innerHTML = `
                <div class="small text-muted mb-1">
                    ${new Date(msg.created_at || Date.now()).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            })}
                </div>
                <div class="msg-text">${msg.message}</div>
            `;
            wrap.appendChild(bubble);

            const container = document.getElementById('messages');
            if (container) {
                if (prepend) {
                    container.prepend(wrap);
                } else {
                    container.appendChild(wrap);
                }
                if (!prepend) {
                    scrollDown();
                }
            } else {
                console.error('Messages container not found');
            }
        }

        function bindForm() {
            const form = document.getElementById('message-form');
            if (!form) return;
            form.addEventListener('submit', async e => {
                e.preventDefault();
                const data = new FormData(form);
                try {
                    const res = await fetch('/chat/message-send', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: data
                    });
                    if (!res.ok) throw res;
                    const json = await res.json();
                    console.log('Server response in bindForm:', json.data);
                    const messagesContainer = document.getElementById('messages');
                    if (messagesContainer && messagesContainer.dataset.chatId === form.dataset.chatId) {
                        renderMessage(json.data);
                        scrollDown();
                    }
                    form.reset();
                } catch (err) {
                    console.error('Error in bindForm:', err);
                }
            });
        }

        function bindLoadMore() {
            const btn = document.getElementById('load-more-btn');
            const wrapper = document.getElementById('load-more-wrapper');
            const container = document.getElementById('messages');
            if (!btn || !container) return;

            btn.addEventListener('click', async () => {
                if (loading) return;
                loading = true;
                isLoadingOlderMessages = true;

                const prevScrollTop = container.scrollTop;
                const prevScrollHeight = container.scrollHeight;

                let page = Number(container.dataset.page || 1) + 1;
                try {
                    const slug = container.dataset.chatSlug || '';
                    const res = await fetch(`/chat/messages-load?slug=${slug}&page=${page}`, {
                        headers: {'Accept': 'application/json'}
                    });
                    if (!res.ok) throw new Error('Load more failed');
                    const json = await res.json();
                    const messages = json.data || [];
                    if (messages.length) {
                        container.dataset.page = page;
                        messages.forEach(m => renderMessage(m, true));
                        if (wrapper) container.prepend(wrapper);
                        const newHeight = container.scrollHeight;
                        container.scrollTop = prevScrollTop + (newHeight - prevScrollHeight);
                    } else {
                        btn.style.display = 'none';
                    }
                } catch (err) {
                    console.error('Load more error:', err);
                } finally {
                    loading = false;
                    isLoadingOlderMessages = false;
                }
            });
        }

        function scrollDown() {
            const container = document.getElementById('messages');
            if (container && !isLoadingOlderMessages) {
                requestAnimationFrame(() => {
                    container.scrollTop = container.scrollHeight;
                });
            }
        }

        document.querySelectorAll('[data-chat-slug]').forEach(btn => {
            btn.addEventListener('click', async () => {
                try {
                    const res = await fetch(`/chat/${btn.dataset.chatSlug || ''}`);
                    if (!res.ok) throw new Error('Failed to load chat');
                    const html = await res.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const chatDetails = document.getElementById('chat-details');
                    if (chatDetails && doc.querySelector('#chat-details-content')) {
                        chatDetails.innerHTML = doc.querySelector('#chat-details-content').outerHTML;
                        bindForm();
                        bindLoadMore();
                        scrollDown();
                    }
                } catch (err) {
                    console.error('Chat load error:', err);
                }
            });
        });
    </script>
@endsection
