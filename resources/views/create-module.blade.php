@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить новый модуль</h1>
        <form action="{{ route('modules.store') }}" method="POST" id="createForm">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название модуля</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Содержание модуля</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="content" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Выберите курс</label>
                <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                    <option value="">Выберите курс</option>
                    @foreach($courses as $course)
                        <option name="course_id" value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" id="createButton" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection

