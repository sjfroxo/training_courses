@extends('layouts.app')

@section('main')
    <div class="d-flex">
        <!-- Список чатов слева -->
        <div class="col-4">
            <ul class="list-unstyled mb-0">
                @foreach($chats as $chat)
                    <li class="p-2">
                        <a href="{{ route('chat.show', $chat->slug) }}" class="d-flex justify-content-between">
                            <div class="d-flex flex-row">
                                <div class="pt-1">
                                    <p class="fw-bold mb-0">{{ $chat->title }}</p>
                                    <p class="small text-muted">{{ $chat->lastMessage->message }}</p>
                                </div>
                            </div>
                            <div class="pt-1">
                                <p class="small text-muted mb-1">{{ $chat->lastMessage->created_at->format('H:i') }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Список пользователей справа -->
        <div class="col-4">
            <ul>
                @foreach($users as $user)
                    <li class="d-flex">
                        <!-- При клике на пользователя вызываем метод создания чата -->
                        <button onclick="createChat({{ $user->id }})">
                            {{ $user->name }} {{ substr($user->surname, 0, 1) }}.
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function createChat(userId) {
            // AJAX-запрос на создание чата с выбранным пользователем
            axios.post('{{ route('chat.create') }}', {
                userId: userId,
            })
                .then(response => {
                    // Если чат создан, перенаправляем на страницу чата
                    window.location.href = '/chat/' + response.data.slug;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

@endsection
