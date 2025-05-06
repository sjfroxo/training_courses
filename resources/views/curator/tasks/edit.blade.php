@extends('layouts.app')

@section('main')
    @include('components.curator.course-header', ['active' => 'tasks'])

    <section class="mt-5">
        <form action="{{ route('curator.courses.tasks.update', $task->id) }}">
            @csrf

            <div class="w-25">
                <label for="name" class="form-label">Название</label>
                <input type="text" name="name" class="input-group" value="{{ old('name') }}">
            </div>

            <div>
                <textarea name="description" id="editor">{{ old('description') }}</textarea>
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
                <input type="date" name="deadline" class="input-group" value="{{ old('deadline') }}">
            </div>

            <div class="d-flex justify-content-between align-items-center w-50 mt-3">
                <a href="{{ route('curator.courses.tasks.index') }}">Отмена</a>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>
@endsection
