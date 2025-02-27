@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Редактирование учебного класса</h1>
        <form action="{{ route('studentsClass.store') }}" method="POST" id="createForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название класса</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Введите название класса" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="course_id" class="form-label">Курс</label>
                <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                    <option value="">Выберите курс</option>
                    @foreach(\App\Models\Course::all() as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="student_ids" class="form-label">Стажёры</label>
                <select class="form-control @error('student_ids') is-invalid @enderror" id="student_ids" name="student_ids[]" multiple required>
                    @foreach(\App\Models\User::query()->where('user_role_id', \App\Enums\UserRoleEnum::USER->value)->get() as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('student_ids', [])) ? 'selected' : '' }}>
                            {{ $user->name }} {{ $user->surname }}
                        </option>
                    @endforeach
                </select>
                @error('student_ids')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Куратор</label>
                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                    <option value="">Выберите куратора</option>
                    @foreach(\App\Models\User::query()->where('user_role_id', \App\Enums\UserRoleEnum::CURATOR->value)->get() as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id }}>
                            {{ $user->name }} {{ $user->surname }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('studentsClass.index') }}" class="btn btn-outline-secondary">Отмена</a>
                <button type="submit" id="createButton" class="btn" style="background-color: #6f42c1; color: white;">Отправить</button>
            </div>
        </form>
    </div>
@endsection
