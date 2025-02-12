@extends('layouts.app')

@section('main')
    <style>
        .message-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            position: relative;
        }

        .message {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 5px;
            cursor: pointer; /* Добавляем курсор указателя */
        }

        .message.sent {
            align-self: flex-end;
        }

        .message.received {
            align-self: flex-start;
        }

        .reply-message {
            background-color: rgba(0, 0, 0, 0.2); /* Цвет фона блока ответа */
            border-left: 3px solid rgba(136, 136, 136, 0.5); /* Линия слева */
            padding: 5px;
            border-radius: 5px;
            color: #000000; /* Цвет текста */
            margin-bottom: 5px;
        }

        .message-content {
            background-color: #f1f1f1; /* Цвет фона сообщения */
            border-radius: 10px;
            padding: 10px;
        }

        .message-content.received {
            background-color: rgba(57, 192, 237, .2); /* Цвет фона полученного сообщения */
        }

        .selected-message {
            border: 2px solid #007bff; /* Выдление выбранног�� сообщения */
        }

        .recording-interface {
            display: none;
            align-items: center;
            justify-content: center;
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .recording-interface.active {
            display: flex;
        }

        .recording-timer {
            margin-left: 10px;
        }

        .audio-player {
            margin-top: 10px;
        }

        .recording-video-interface {
            display: none;
            align-items: center;
            justify-content: center;
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .recording-video-interface.active {
            display: flex;
        }

        .video-preview {
            display: none;
        }

        .video-preview.active {
            display: block;
            margin-top: 10px;
            width: 100%;
            border-radius: 10px;
        }
    </style>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" id="chat1" style="border-radius: 15px;">
                        <div
                                class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                                style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <i class="fas fa-angle-left"></i>
                            <p class="mb-0 fw-bold">{{$chat->title}}</p>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="card-body" id="card-body" style="max-height: 569px; overflow-y: auto;">
                            @foreach($messages->reverse() as $message)
                                <div class="message-container">
                                    <div class="message {{ $message->user_id == auth()->user()->id ? 'sent' : 'received' }}"
                                         data-message-id="{{ $message->id }}">
                                        <div class="message-content {{ $message->user_id == auth()->user()->id ? '' : 'received' }}">
                                            @if($message->reply_message_id != null)
                                                <div class="reply-message">
                                                    {{$replyMessages[$message->reply_message_id]}}
                                                </div>
                                            @endif
                                            @if($message->type == "text")
                                                <p class="small mb-0">{{$message->message}}</p>
                                            @elseif($message->type == "voice")
                                                <audio controls class="" style="width:170px">
                                                    <source src="{{$voiceMessages[$message->id]}}" type="audio/mpeg">
                                                </audio>
                                            @else
                                                <video controls class="" style="width:170px">
                                                    <source src="{{$videoMessages[$message->id]}}">
                                                </video>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div data-mdb-input-init class="form-outline">
                            <form action="javascript:void(0)" id="message" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea class="form-control" id="textAreaExample" placeholder="enter your message"
                                          rows="4"></textarea>
                                <input type="hidden" id="replyMessageId" name="reply_message_id" value="">
                                <div class="container">
                                    <i id="recordButton" class="fa fa-microphone"
                                       style="font-size: 24px; cursor: pointer;"></i>
                                    <i id="recordVideoButton" class="col-1 m-3 fa-solid fa-video"></i>
                                    <div class="recording-interface" id="recordingInterface">
                                        <span class="recording-indicator">🔴 Recording...</span>
                                        <span class="recording-timer" id="recordingTimer">00:00</span>
                                    </div>
                                    <div class="recording-video-interface" id="recordingVideoInterface">
                                        <span class="recording-indicator">🔴 Recording Video...</span>
                                        <span class="recording-timer" id="recordingVideoTimer">00:00</span>
                                    </div>
                                    <video id="videoPreview" class="video-preview" playsinline></video>
                                    <div class="messages" id="messages"></div>
                                </div>
                                <div class="row justify-content-between">
                                    <button type="submit" id="sendRequestButton" class="col-5 mx-3">Send Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentScrollPosition = 0;
        let lastMessageId = {{$messages[count($messages)-1]->id}};
        let replyMessages = @json($replyMessages);
        let voiceMessages = @json($voiceMessages);
        let videoMessages = @json($videoMessages);
        let replyMessageHtml = '';
        let messageContent = '';

        function loadMoreMessages() {
            $.ajax({
                url: '{{ route("chat.loadMore", ['slug' => $slug]) }}',
                type: 'get',
                data: {
                    last_message_id: lastMessageId,
                },
                success: function (response) {
                    console.log(response);
                    // response = response['data'];

                    const messages = response.data;

                    messages.forEach(function (message) {
                        prependNewMessage(message);
                    });

                    if (messages.length > 0) {
                        lastMessageId = messages[messages.length - 1].id;
                    }

                    $('#card-body').scrollTop($('#card-body')[0].scrollHeight - currentScrollPosition);
                }
            });
        }

        $('#card-body').scroll(function () {
            currentScrollPosition = $('#card-body')[0].scrollHeight - $('#card-body').scrollTop();

            if ($('#card-body').scrollTop() === 0) {
                loadMoreMessages();
            }
        });

        function prependNewMessage(message) {
            replyMessageHtml = '';
            messageContent = '';
            if (message.reply_message_id) {
                replyMessageHtml = `
                <div class="reply-message">
                    ${replyMessages[message.reply_message_id]}
                </div>
            `;
            }

            if (message.type === 'text') {
                messageContent = `<p class="small mb-0">${message.message}</p>`;
            } else if (message.type === 'voice') {
                messageContent = `
                <audio controls style="width:170px">
                    <source src="${voiceMessages[message.id]}" type="audio/mpeg">
                </audio>
            `;
            } else {
                messageContent = `
                <video controls style="width:170px">
                    <source src="${videoMessages[message.id]}">
                </video>
            `;
            }

            let newMessage = `
            <div class="message-container">
                <div class="message ${message.user_id === {{auth()->user()->id}} ? 'sent' : 'received'}" data-message-id="${message.id}">
                    <div class="message-content ${message.user_id === {{auth()->user()->id}} ? '' : 'received'}">
                        ${replyMessageHtml}
                        ${messageContent}
                    </div>
                </div>
            </div>
        `;

            $(".card-body").prepend(newMessage);
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            newMessageToOthers();

            $('#message').submit(function (e) {
                e.preventDefault();
                sendMessage($('#textAreaExample').val(), "text", null);
            });


        });

        function sendMessage(content, type, mediaBlob = null) {
            const formData = new FormData();

            formData.append('user_id', {{ auth()->user()->id }});
            formData.append('chat_id', {{ $chat->id }});
            formData.append('type', type);
            formData.append('reply_message_id', $('#replyMessageId').val());
            formData.append('message', content);

            if ((type === 'voice' || type === 'video') && mediaBlob) {
                formData.append('media_file', mediaBlob);
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("message.store") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = response['data'];
                    console.log(response);
                    newOwnMessage(response);

                    newMessageToOthers();

                    $(".card-body").scrollTop($(".card-body")[0].scrollHeight);

                    $('.message').removeClass('selected-message');

                    $('#replyMessageId').val('');
                },
                error: function (error) {
                    console.log('Error:', error.responseJSON);
                },
            });
        }

        $(".card-body").scrollTop($(".card-body")[0].scrollHeight);

        function newOwnMessage(message) {
            let replyMessageHtml = '';
            let messageContent = '';

            if (message.reply_message_id) {
                replyMessageHtml = replyMessageHtml = replyChoose(message.reply_message_id);
            }

            messageContent = messageContentChoose(message.message, message.type, message.media_url);

            let newMessage = `
        <div class="message-container">
            <div class="message sent" data-message-id="${message.id}">
                <div class="message-content">
                    ${replyMessageHtml}
                    ${messageContent}
                </div>
            </div>
        </div>
    `;

            $(".card-body").append(newMessage);
        }

        function newMessageToOthers() {
            let messageContent = "";

            Echo.channel('chat.{{$chat->id}}').stopListening('.chat-message.sent');

            Echo.channel('chat.{{$chat->id}}')
                .listen('.chat-message.sent', (e) => {

                    if (e.reply_message_id) {
                        replyMessageHtml = replyChoose(e.reply_message_id);
                    }

                    messageContent = messageContentChoose(e.message, e.type, e.media_url)

                    let newMessage = `
                    <div class="message-container">
                        <div class="message received" data-message-id="${e.id}">
                            <div class="message-content received">
                                ${replyMessageHtml}
                                ${messageContent}
                            </div>
                        </div>
                    </div>

                `;

                    $(".card-body").append(newMessage);

                    $(".card-body").scrollTop($(".card-body")[0].scrollHeight);
                });

            $('#textAreaExample').val('');
        }

        function replyChoose(reply_id) {
            let replyMessage = "";

            if ($(`.message[data-message-id="${reply_id}"]`).find('p').length > 0) {
                replyMessage = $(`.message[data-message-id="${reply_id}"]`).find('p').text();
            } else if ($(`.message[data-message-id="${reply_id}"]`).find('audio').length > 0) {
                replyMessage = "voice message";
            } else if ($(`.message[data-message-id="${reply_id}"]`).find('video').length > 0) {
                replyMessage = "video message";
            }

            return `
                        <div class="reply-message">
                            ${replyMessage}
                        </div>
                    `;
        }

        function messageContentChoose(message, type, media_url) {
            if (type === 'text') {
                return `<p class="small mb-0">${message}</p>`;
            } else if (type === 'voice') {
                return `
            <audio controls style="width:170px">
                <source src="${media_url}" type="audio/mpeg">
            </audio>
        `;
            } else if (type === 'video') {
                return `
            <video controls style="width:170px">
                <source src="${media_url}">
            </video>
        `;
            }
        }

        $('.card-body').on('click', '.message', function () {

            const isSelected = $(this).hasClass('selected-message');

            $('.message').removeClass('selected-message');

            if (!isSelected) {
                $(this).addClass('selected-message');
                $('#replyMessageId').val($(this).data('message-id'));
            } else {
                $('#replyMessageId').val('');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                $('#message').submit();
            }
        }, {passive: true});

        const recordButton = document.getElementById('recordButton');
        const recordingInterface = document.getElementById('recordingInterface');
        const recordingTimer = document.getElementById('recordingTimer');
        let mediaRecorder;
        let audioChunks = [];
        let timerInterval;
        let startTime;
        let isRecording = false;

        recordButton.addEventListener('click', async () => {
            if (!isRecording) {
                const stream = await navigator.mediaDevices.getUserMedia({audio: true});
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = (e) => {
                    audioChunks.push(e.data);
                };

                mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(audioChunks, {type: 'audio/wav'});
                    sendMessage(null, 'voice', audioBlob);
                };

                mediaRecorder.start();
                audioChunks = [];
                startTime = Date.now();
                recordingInterface.classList.add('active');
                startTimer();
                isRecording = true;
            } else {
                mediaRecorder.stop();
                recordingInterface.classList.remove('active');
                stopTimer();
                isRecording = false;
            }
        }, {passive: true});

        function startTimer() {
            timerInterval = setInterval(() => {
                const elapsedTime = Date.now() - startTime;
                const seconds = Math.floor((elapsedTime / 1000) % 60);
                const minutes = Math.floor((elapsedTime / 1000 / 60) % 60);
                recordingTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function stopTimer() {
            clearInterval(timerInterval);
            recordingTimer.textContent = '00:00';
        }

        const recordVideoButton = document.getElementById('recordVideoButton');
        const recordingVideoInterface = document.getElementById('recordingVideoInterface');
        const recordingVideoTimer = document.getElementById('recordingVideoTimer');
        const videoPreview = document.getElementById('videoPreview');
        let mediaRecorderVideo;
        let videoChunks = [];
        let timerVideoInterval;
        let startVideoTime;
        let isRecordingVideo = false;

        recordVideoButton.addEventListener('click', async () => {
            if (!isRecordingVideo) {
                const stream = await navigator.mediaDevices.getUserMedia({video: true, audio: true});
                mediaRecorderVideo = new MediaRecorder(stream);

                videoPreview.srcObject = stream;
                videoPreview.classList.add('active');
                videoPreview.play();

                mediaRecorderVideo.ondataavailable = (e) => {
                    videoChunks.push(e.data);
                };

                mediaRecorderVideo.onstop = () => {
                    const videoBlob = new Blob(videoChunks, {type: 'video/webm'});
                    sendMessage(null, 'video', videoBlob);
                    videoPreview.classList.remove('active');
                    videoPreview.srcObject = null;
                };

                mediaRecorderVideo.start();
                videoChunks = [];
                startVideoTime = Date.now();
                recordingVideoInterface.classList.add('active');
                startVideoTimer();
                isRecordingVideo = true;
            } else {
                mediaRecorderVideo.stop();
                recordingVideoInterface.classList.remove('active');
                stopVideoTimer();
                isRecordingVideo = false;
            }
        }, {passive: true});

        function startVideoTimer() {
            timerVideoInterval = setInterval(() => {
                const elapsedTime = Date.now() - startVideoTime;
                const seconds = Math.floor((elapsedTime / 1000) % 60);
                const minutes = Math.floor((elapsedTime / 1000 / 60) % 60);
                recordingVideoTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function stopVideoTimer() {
            clearInterval(timerVideoInterval);
            recordingVideoTimer.textContent = '00:00';
        }
    </script>
@endsection

