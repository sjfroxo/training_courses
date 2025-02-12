@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Редактировать модуль</h1>
        <form action="{{route('modules.update', ['slug' => $module->slug])}}" method="POST">
            @csrf
            @method('PATCH')
            {{--Скрытое поле которое содержит текущий course_id--}}
            <input type="hidden" name="course_id" value="{{ $module->course_id }}">

            <div class="mb-3">
                <label for="title" class="form-label">Название модуля</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{ old('title', $module->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Содержание модуля</label>
                <textarea class="form-control" id="description" name="content" rows="3"
                          required>{{ old('description', $module->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection('main')
