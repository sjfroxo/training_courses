@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Редактировать курс</h1>
        <form action="{{route('courses.update', ['slug' => $course->slug])}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="title" class="form-label">Название курса</label>
                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name="title"
                       value="{{ old('title', $course->title) }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание курса</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          name="description" rows="3" required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>

@endsection('main')
