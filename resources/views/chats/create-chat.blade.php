<div class="modal fade" id="createChatModal" tabindex="-1" aria-labelledby="createChatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('chat.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createChatModalLabel">Создание чата</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Пользователь</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="" disabled selected>Выберите пользователя</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Название чата</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Введите название чата"
                           required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>
</div>
