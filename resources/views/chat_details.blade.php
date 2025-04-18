@extends('layouts.app')

@section('main')
    <style>
        .message-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            position: relative;
        }

        .message {
            max-width: 70%;
            padding: 12px;
            border-radius: 15px;
            position: relative;
            margin-bottom: 5px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message.sent {
            align-self: flex-end;
            background-color: #a5d6a7;
            color: #fff;
        }

        .message.received {
            align-self: flex-start;
            background-color: #e0f7fa;
            color: #333;
        }

        .message.sent::before {
            left: auto;
            right: 5px;
        }

        .message::after {
            content: attr(data-time);
            position: absolute;
            bottom: -20px;
            right: 5px;
            font-size: 12px;
            color: #666;
        }

        .message.received::after {
            right: auto;
            left: 5px;
        }

        .reply-message {
            background-color: rgba(0, 0, 0, 0.2);
            border-left: 3px solid rgba(136, 136, 136, 0.5);
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .message-content {
            border-radius: 10px;
            padding: 10px;
        }

        .selected-message {
            border: 2px solid #007bff;
        }

        .reply-preview {
            background-color: #f8f9fa;
            border-left: 3px solid #007bff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: none;
        }

        .reply-preview .cancel-reply {
            cursor: pointer;
            color: #dc3545;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .message {
                max-width: 90%;
            }
        }
    </style>
    <section>
        <div class="container py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" id="chat1" style="border-radius: 15px;">
                        <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                             style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <i class="fas fa-angle-left"></i>
                            <p class="mb-0 fw-bold">{{ $chat->title }}</p>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="card-body" id="card-body" style="max-height: 569px; overflow-y: auto;">
                            @foreach($messages->sortBy('created_at') as $message)
                                <div class="message-container">
                                    <div class="message {{ $message->user_id == auth()->id() ? 'sent' : 'received' }}"
                                         data-message-id="{{ $message->id }}"
                                         data-time="{{ $message->formatted_time }}">
                                        <div class="message-content">
                                            @if($message->reply_message_id && $message->repliedToMessage)
                                                <div class="reply-message">
                                                    {{ $message->repliedToMessage->message }}
                                                </div>
                                            @endif
                                            @if($message->type == 'text')
                                                <p class="small mb-0">{{ $message->message }}</p>
                                            @elseif($message->type == 'voice' && isset($voiceMessages[$message->id]))
                                                <audio controls style="width:170px">
                                                    <source src="{{ $voiceMessages[$message->id] }}" type="audio/webm">
                                                </audio>
                                            @elseif($message->type == 'video' && isset($videoMessages[$message->id]))
                                                <video controls style="width:170px">
                                                    <source src="{{ $videoMessages[$message->id] }}" type="video/webm">
                                                </video>
                                            @else
                                                <p class="small mb-0">[Media unavailable]</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-outline p-3">
                            <form id="message-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="reply-preview" id="reply-preview">
                                    <p id="reply-text" class="mb-0"></p>
                                    <span class="cancel-reply" onclick="cancelReply()">Отменить</span>
                                </div>
                                <textarea class="form-control mb-2" id="textAreaExample" name="message"
                                          placeholder="Введите сообщение" rows="3"></textarea>
                                <input type="hidden" id="replyMessageId" name="reply_message_id" value="">
                                <button type="submit" class="btn btn-primary w-100">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Vite directive to include compiled assets -->
    @vite(['resources/js/app.js'])

    <!-- Pass variables to JavaScript -->
    <script>
        window.currentUserId = {{ auth()->id() }};
        window.chatId = {{ $chat->id }};
    </script>

    <!-- Form submission and real-time updates -->
    <script>
        $(document).ready(function () {
            let selectedMessageId = null;

            // Функция для рендеринга сообщения
            function renderMessage(message) {
                const isSent = message.user_id === window.currentUserId;
                return `
                    <div class="message-container">
                        <div class="message ${isSent ? 'sent' : 'received'}"
                             data-message-id="${message.id}"
                             data-time="${new Date(message.created_at).toLocaleTimeString()}">
                            <div class="message-content">
                                ${message.reply_message_id && message.replied_to_message ? `
                                    <div class="reply-message">
                                        ${message.replied_to_message.message}
                                    </div>
                                ` : ''}
                                ${message.type === 'text' ? `
                                    <p class="small mb-0">${message.message}</p>
                                ` : message.type === 'voice' && message.media_url ? `
                                    <audio controls style="width:170px">
                                        <source src="${message.media_url}" type="audio/webm">
                                    </audio>
                                ` : message.type === 'video' && message.media_url ? `
                                    <video controls style="width:170px">
                                        <source src="${message.media_url}" type="video/webm">
                                    </video>
                                ` : `
                                    <p class="small mb-0">[Media unavailable]</p>
                                `}
                            </div>
                        </div>
                    </div>
                `;
            }

            // Проверка, находится ли пользователь внизу чата
            function isAtBottom() {
                const chat = document.getElementById('card-body');
                return chat.scrollTop + chat.clientHeight >= chat.scrollHeight - 10;
            }

            // Прокрутка вниз
            function scrollToBottom() {
                const chat = document.getElementById('card-body');
                chat.scrollTop = chat.scrollHeight;
            }

            // Выделение сообщения
            $('.message').click(function () {
                $('.message').removeClass('selected-message');
                $(this).addClass('selected-message');
                selectedMessageId = $(this).data('message-id');
                const messageText = $(this).find('.message-content p').text() || '[Медиа]';
                $('#reply-preview').show();
                $('#reply-text').text(messageText);
                $('#replyMessageId').val(selectedMessageId);
            });

            // Отмена ответа
            window.cancelReply = function () {
                $('.message').removeClass('selected-message');
                selectedMessageId = null;
                $('#reply-preview').hide();
                $('#reply-text').text('');
                $('#replyMessageId').val('');
            };

            // Отправка формы
            $('#message-form').submit(function (e) {
                console.log('Форма отправлена');
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('user_id', window.currentUserId);
                formData.append('chat_id', window.chatId);
                formData.append('type', 'text');
                formData.append('message', $('#textAreaExample').val());

                $.ajax({
                    url: '{{ route("message.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#textAreaExample').val('');
                        cancelReply();
                        scrollToBottom();
                    },
                    error: function (error) {
                        console.error('Ошибка отправки сообщения:', error);
                    }
                });
            });

            if (window.Echo && window.chatId) {
                console.log('Подписка на канал: private-chat.' + window.chatId);
                const channel = window.Echo.channel(`chat.${window.chatId}`);
                console.log('Канал подписки:', channel);

                channel.listen('MessageSent', (e) => {
                    console.log('Событие .MessageSent получено:', e);
                    const atBottom = isAtBottom();
                    $('#card-body').append(renderMessage({
                        ...e,
                        reply_to_message: e.replied_to_message
                    }));
                    if (atBottom) scrollToBottom();

                    // Добавить обработчик клика для нового сообщения
                    $(`[data-message-id="${e.id}"]`).click(function () {
                        $('.message').removeClass('selected-message');
                        $(this).addClass('selected-message');
                        selectedMessageId = $(this).data('message-id');
                        const messageText = $(this).find('.message-content p').text() || '[Медиа]';
                        $('#reply-preview').show();
                        $('#reply-text').text(messageText);
                        $('#replyMessageId').val(selectedMessageId);
                    });
                });
            } else {
                console.error('window.Echo или window.chatId не определены');
            }

            window.addEventListener('load', scrollToBottom);
        });
    </script>
@endsection
