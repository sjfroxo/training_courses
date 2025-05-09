<div id="chat-details-content" class="d-flex flex-column" style="height: 95vh;">
    <h5 class="mb-3">
        @if($chat->users->count() === 1 && $chat->users->first()->id === auth()->id())
            Избранное
        @else
            {{ $chat->users->where('id', '!=', auth()->id())->first()->name ?? 'Избранное' }}
        @endif
    </h5>
    <div
        id="messages"
        class="mb-3 overflow-auto"
        data-chat-id="{{ $chat->id }}"
        data-chat-slug="{{ $chat->slug }}"
        data-page="1"
        style="flex: 1 1 auto; min-height: 0;"
    >
        @if($messages->count() >= 25)
            <div class="text-center mb-2" id="load-more-wrapper">
                <button id="load-more-btn" class="btn btn-outline-secondary">Загрузить больше</button>
            </div>
        @endif
        @foreach($messages as $message)
            @php
                $isMine = $message->user_id === auth()->id();
            @endphp
            @if($isMine ===   true)
                <div class="d-flex mb-2 justify-content-end chat-message" data-id="{{ $message->id }}">
                    <div class="p-2 rounded" style="background-color: #c6fff7; max-width:70%;">
                        <div class="small text-muted mb-1">{{ $message->created_at->format('H:i') }}</div>
                        <div class="msg-text">{{ $message->message }}</div>
                    </div>
                </div>
            @else
                <div class="d-flex mb-2 justify-content-start chat-message" data-id="{{ $message->id }}">
                    <div class="p-2 rounded" style="background-color: #ececec; max-width:70%;">
                        <div class="small text-muted mb-1">{{ $message->created_at->format('H:i') }}</div>
                        <div class="msg-text">{{ $message->message }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <form id="message-form" data-chat-id="{{ $chat->id }}" style="flex: 0 0 auto;">
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
