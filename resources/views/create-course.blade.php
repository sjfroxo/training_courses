@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить новый курс</h1>
        <form action="{{ route('courses.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Название курса</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание курса</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Изображение курса</label>
                <input
                    type="file"
                    name="avatar"
                    id="avatar"
                    class="form-control @error('avatar') is-invalid @enderror"
                    alt="Нажмите для загрузки изображения"
                />
            </div>
            <button type="submit" id="createButton" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection

