@extends('layouts.app')

@section('main')
    <section class="w-100">

        @include('components.curator.course-header', ['active' => 'tasks'])

        <section class="mt-5">
            <form method="POST" action="{{ route('curator.course.task.update', $task->id) }}">
                @csrf
                @method('PUT')

                <div class="w-25">
                    <label for="name" class="form-label">Название</label>
                    <input type="text" name="name" class="input-group" value="{{ $task->name }}">
                </div>

                <div>
                    <textarea name="description" id="editor">{{ $task->description }}</textarea>
                </div>

                <div class="w-25">
                    <label for="users">Для кого</label>

                    <select name="users" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-25">
                    <label for="deadline" class="form-label">Срок сдачи</label>
                    <input type="date" name="deadline" class="input-group" value="{{ $task->deadline }}">
                </div>

                <div class="d-flex justify-content-between align-items-center w-50 mt-3">
                    <a href="{{ route('curator.course.task.index') }}">Отмена</a>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </section>
    </section>
@endsection
