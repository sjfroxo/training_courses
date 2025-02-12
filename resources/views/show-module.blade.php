@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h4>{{$module->title}}</h4>

                @can('create',$module)
                    <a type="button" class="btn btn-primary" href="{{route('moduleExams.create')}}">Добавить тест</a>
                @endcan
            </div>
            <div class="card-body">
                {{$module->content}}
                @if(count($module->moduleExams) > 0)
                    <x-exam-list :exams="$module->moduleExams"/>
                @endif


            </div>
        </div>

        <h4>Комментарии</h4>
        <div class="row">
            <div class="col-md-8">
                <!-- Список комментариев -->
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
                <!-- Форма для добавления комментария -->
                <form action="{{ route('moduleComments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="module_id" value="{{ $module->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <label for="text" class="form-label">Добавить комментарий</label>
                        <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
        </div>

        <script>
            function showEditForm(commentId) {
                const commentContent = document.getElementById('comment-content-' + commentId);
                const editForm = document.getElementById('edit-form-' + commentId);

                const newEditForm = document.createElement('form');
                newEditForm.action = editForm.action;
                newEditForm.method = 'POST';
                newEditForm.innerHTML = `
            @csrf
                @method('PATCH')
                <input type="hidden" name="user_id" value="{{ $comments && $comments->count() > 0 ? $comments[0]->user->id : '' }}">
            <input type="hidden" name="module_id" value="{{ $comments && $comments->count() > 0 ? $comments[0]->module->id : '' }}">
            <textarea name="text" class="form-control">${editForm.querySelector('textarea').value}</textarea>
            <button type="submit" class="btn btn-sm btn-primary mt-2">Сохранить</button>
        `;

                commentContent.innerHTML = '';
                commentContent.appendChild(newEditForm);
            }
        </script>
@endsection
