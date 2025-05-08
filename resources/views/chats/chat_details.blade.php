<div id="chat-details-content" class="d-flex flex-column" style="height: 95vh;">
    <h5 class="mb-3">{{ $chat->title }}</h5>
    <div
        id="messages"
        class="flex-grow-1 mb-3 overflow-auto"
        data-chat-id="{{ $chat->id }}"
        data-chat-slug="{{ $chat->slug }}"
        data-page="1"
    >
        @if($messages->count() >= 25)
            <div class="text-center mb-2" id="load-more-wrapper">
                <button id="load-more-btn" class="btn btn-outline-secondary">Загрузить больше</button>
            </div>
        @endif
        @foreach($messages as $message)
            @php
                $isMine = $message->user_id === auth()->id();
                $align  = $isMine ? 'justify-content-end' : 'justify-content-start';
                $cls    = $isMine ? ($mineBubbleClass ?? 'bg-primary text-white') : ($otherBubbleClass ?? 'bg-light text-dark');
            @endphp
            <div class="d-flex mb-2 {{ $align }} chat-message" data-id="{{ $message->id }}">
                <div class="p-2 rounded {{ $cls }}" style="max-width:70%;">
                    <div class="small text-muted mb-1">{{ $message->created_at->format('h:i A') }}</div>
                    <div class="msg-text">{{ $message->message }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="message-form" data-chat-id="{{ $chat->id }}">
        @csrf
        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="type" value="text">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Написать сообщение..." required>
            <button class="btn btn-primary" type="submit">Отправить</button>
        </div>
    </form>
</div>
