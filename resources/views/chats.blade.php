@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Ваши чаты</h3>
                <div class="list-group">
                    @forelse($chats as $chat)
                        <a href="{{ route('chat.show', $chat->slug) }}" class="list-group-item list-group-item-action mb-2 shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $chat->title }}</h5>
                                <small class="text-muted">{{ $chat->lastMessage()?->formatted_time ?? 'Нет сообщений' }}</small>
                            </div>
                            <p class="mb-1 text-truncate">{{ $chat->lastMessage()?->message ?? 'Начните общение!' }}</p>
                        </a>
                    @empty
                        <p class="text-muted">У вас пока нет чатов.</p>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="mb-3">Пользователи</h3>
                <div class="list-group">
                    @foreach($users as $user)
                        <button class="list-group-item list-group-item-action mb-2 shadow-sm" onclick="createChat({{ $user->id }})">
                            {{ $user->name }} {{ substr($user->surname, 0, 1) }}.
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function createChat(userId) {
            axios.post('{{ route('chat.create') }}', { user_id: userId })
                .then(response => {
                    if (response.data.status === 'success' || response.data.status === 'exists') {
                        window.location.href = '/chat/' + response.data.chat.slug;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
