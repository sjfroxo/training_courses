@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить пользователя</h1>
        <form action="{{ route('users.store') }}" method="POST" id="createForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}" required>
                @error('surname')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_role_id" class="form-label">Выберите роль</label>
                <select class="form-select @error('user_role_id') is-invalid @enderror" id="user_role_id" name="user_role_id" required>
                    <option value="">Выберите роль</option>
                    @foreach($roles as $role)
                        <option name="user_role_id" value="{{ $role->id }}" {{ old('user_role_id') == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                    @endforeach
                </select>
                @error('user_role_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" id="createButton" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection

