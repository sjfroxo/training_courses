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
                                data-chat-slug="{{ $chat->slug }}">
                            <div class="fw-bold">{{ $chat->title }}</div>
                            <small class="text-muted">{{ $chat->lastMessage()?->message ?? 'Начните общение!' }}</small>
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
    <div id="context-menu" class="position-absolute bg-white border rounded shadow-sm p-2 d-none" style="z-index: 1050;">
        <button class="dropdown-item" id="edit-msg">Редактировать</button>
        <button class="dropdown-item text-danger" id="delete-msg">Удалить</button>
    </div>

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

        document.getElementById('delete-msg').addEventListener('click', async () => {
            if (!currentMessageEl || !currentMessageId) return;

            const res = await fetch(`/chat/message/${currentMessageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            currentMessageEl.remove();
            document.getElementById('context-menu').classList.add('d-none');
        });

        document.getElementById('edit-msg').addEventListener('click', () => {
            if (!currentMessageEl) return;
            const originalText = currentMessageEl.querySelector('.msg-text').innerText;
            const input = prompt('Редактировать сообщение:', originalText);
            if (input === null) return;

            fetch(`/chat/message/${currentMessageId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: input })
            });
            document.getElementById('context-menu').classList.add('d-none');
        });

        function subscribeToChannel() {
            const messagesEl = document.getElementById('messages');
            if (!messagesEl) return;

            const chatId = {{ $chat->id }};
            window.Echo.leave(`private-chat.${chatId}`);
            window.Echo.private(`chat.${chatId}`)
                .listen('MessageDeleted', (e) => {
                    console.log(e)
                    const el = document.querySelector(`.chat-message[data-id="${e.messageId}"]`);
                    if (el) el.remove();
                })
                .listen('MessageUpdated', (e) => {
                    console.log(e)
                    const el = document.querySelector(`.chat-message[data-id="${e.message.id}"]`);
                    if (el) el.querySelector('.msg-text').textContent = e.message.message;
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            subscribeToChannel();
        });

        (() => {
            let loading = false;
            let isLoadingOlderMessages = false;

            function renderMessage(msg, prepend = false) {
                const myId  = Number(document.body.dataset.myId);
                const mine  = Number(msg.user_id) === myId;
                const align = mine ? 'justify-content-start' : 'justify-content-end';
                const cls   = mine ? 'bg-light text-dark' : 'bg-primary text-white';

                const wrap = document.createElement('div');
                wrap.className = `d-flex mb-2 ${align}`;

                const bubble = document.createElement('div');
                bubble.className = `p-2 rounded ${cls}`;
                bubble.style.maxWidth = '70%';
                bubble.innerHTML = `
            <div class="small text-muted mb-1">
                ${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false })}
            </div>
            <div class="msg-text">${msg.message}</div>
        `;
                wrap.appendChild(bubble);

                const container = document.getElementById('messages');
                if (prepend) {
                    container.prepend(wrap);
                } else {
                    container.appendChild(wrap);
                }
            }

            function bindLoadMore() {
                const btn = document.getElementById('load-more-btn');

                if (btn) {
                    const btnWrapper = document.getElementById('load-more-wrapper');
                    const container = document.getElementById('messages');

                    btn.addEventListener('click', async () => {
                        if (loading) return;
                        loading = true;
                        isLoadingOlderMessages = true;

                        let page = Number(container.dataset.page) + 1;
                        try {
                            const slug = container.dataset.chatSlug;
                            const res = await fetch(`/chat/messages-load?slug=${slug}&page=${page}`, {
                                headers: {'Accept':'application/json'}
                            });
                            if (!res.ok) throw res;
                            const json = await res.json();
                            const msgs = json.data;
                            if (msgs.length) {
                                container.dataset.page = page;
                                msgs.reverse().forEach(msg => renderMessage(msg, true));
                                container.prepend(btnWrapper);

                                container.scrollTop = currentScroll;
                            } else {
                                btn.style.display = 'none';
                            }
                        } catch (err) {
                            console.error(err);
                        } finally {
                            loading = false;
                            isLoadingOlderMessages = false;
                        }
                    });
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
                        renderMessage(json.data);
                        form.reset();
                        scrollDown();
                    } catch (err) {
                        console.error(err);
                    }
                });
            }

            function scrollDown() {
                const container = document.getElementById('messages');
                if (!container) return;
                if (!isLoadingOlderMessages) {
                    container.scrollTop = container.scrollHeight;
                }
            }

            document.querySelectorAll('[data-chat-slug]').forEach(btn =>
                btn.addEventListener('click', async () => {
                    const res  = await fetch(`/chat/${btn.dataset.chatSlug}`);
                    const html = await res.text();
                    const doc  = new DOMParser().parseFromString(html,'text/html');
                    document.getElementById('chat-details')
                        .innerHTML = doc.querySelector('#chat-details-content').outerHTML;

                    bindForm();
                    bindLoadMore();
                    scrollDown();
                    subscribeToChannel(); // подписка на новые сообщения
                })
            );
        })();
    </script>
@endsection
