@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить новый класс</h1>
        <form action="{{ route('studentsClass.store') }}" method="POST" id="createForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название класса</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Курс</label>
                <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
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
                <label for="curator_id" class="form-label">Куратор (преподаватель)</label>
                <select class="form-control @error('curator_id') is-invalid @enderror" id="curator_id" name="curator_id" required>
                    @foreach(\App\Models\User::query()->where('user_role_id', \App\Enums\UserRoleEnum::CURATOR->value)->get() as $user)
                        <option value="{{ $user->id }}" {{ old('curator_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} {{ $user->surname }}
                        </option>
                    @endforeach
                </select>
                @error('curator_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="student_ids" class="form-label">Ученики</label>
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
            <button type="submit" id="createButton" class="btn btn-primary">Добавить</button>
            <!-- Отладка: выведем отправляемые данные -->
            <input type="hidden" name="debug" value="1">
        </form>
    </div>
@endsection
