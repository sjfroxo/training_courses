@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить пользователя</h1>

        <form action="{{ route('users.update',['user' => $user->id ]) }}" method="POST" id="createForm">
            @csrf
            @method('PATCH')
            {{--Скрытое поле которое содержит текущий password--}}
            <input type="hidden" name="password" value="{{ $user->password}}">

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name',$user->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                       name="surname" value="{{ old('surname',$user->surname) }}" required>
                @error('surname')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email',$user->email) }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_role_id" class="form-label">Выберите роль</label>
                <select class="form-select @error('user_role_id') is-invalid @enderror" id="user_role_id"
                        name="user_role_id" required>
                    <option value="">Выберите роль</option>
                    @foreach($roles as $role)
                        <option name="user_role_id"
                                value="{{ $role->id }}" {{ $user->user_role_id == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                    @endforeach
                </select>
                @error('user_role_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" id="createButton" class="btn btn-primary">Изменить</button>
        </form>
    </div>
@endsection


