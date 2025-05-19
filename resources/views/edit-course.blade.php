@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Редактировать курс</h1>
        <form action="{{route('courses.update', ['slug' => $course->slug])}}" method="POST" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="avatar" class="form-label">Аватар курса</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($course->image_url)
                    <div class="mt-2">
                        <p>Текущее изображение:</p>
                        <img src="{{ asset('storage/' . $course->image_url) }}" alt="{{ $course->title }}"
                             style="max-width: 150px; height: auto; border-radius: 5px;">
                    </div>
                @else
                    <p class="text-muted mt-2">Изображение отсутствует</p>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>

@endsection
