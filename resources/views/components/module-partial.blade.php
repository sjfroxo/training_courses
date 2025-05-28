<div class="card-header">
    <h4>{{ $module->title }}</h4>
    @can('create', $module)
        <a href="{{ route('moduleExams.create', ['module' => $module->id]) }}" class="btn btn-primary">
            Добавить тест
        </a>
    @endcan
</div>

<div class="card-body">
    {!! $module->content !!}

    @if($module->moduleExams->count() > 0)
        <x-exam-list :exams="$module->moduleExams"/>
    @endif
</div>

<!-- Комментарии -->
<h4 class="mt-4">Комментарии</h4>
<div class="row">
    <div class="col-md-8">
        @if($comments && $comments->count() > 0)
            @foreach($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $comment->user->name }}</h5>
                        <div id="comment-content-{{ $comment->id }}">
                            <p class="card-text">{{ $comment->text }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <small
                                class="text-muted me-auto">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                            <!-- Кнопки редактирования и удаления комментария -->
                            @can('delete', $comment)
                                <div class="d-flex justify-content-end">
                                    <button onclick="showEditForm({{ $comment->id }})"
                                            class="btn btn-sm btn-outline-secondary me-2">Редактировать
                                    </button>
                                    <form id="edit-form-{{ $comment->id }}"
                                          action="{{ route('moduleComments.update', $comment) }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="text"
                                                  class="form-control">{{ $comment->text }}</textarea>
                                        <button type="submit" class="btn btn-sm btn-primary mt-2">Сохранить
                                        </button>
                                    </form>
                                    <form
                                        action="{{ route('moduleComments.destroy', ['moduleComment' => $comment->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?')">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Комментариев пока нет.</p>
        @endif

        <!-- Форма добавления комментария -->
        <form action="{{ route('moduleComments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="module_id" value="{{ $module->id }}">
            <div class="mb-3">
                <label for="comment-text" class="form-label">Добавить комментарий</label>
                <textarea class="form-control" id="comment-text" name="text" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
</div>
