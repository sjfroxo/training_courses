@extends('layouts.app')

@section('main')
    <div class="container d-flex justify-content-center align-items-center py-5 h-100">
        <div class="card shadow-lg p-4 text-white" style="width: 400px; background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
            <div class="card-body">
                <h2 class="fw-bold text-center text-uppercase">Регистрация</h2>
                <p class="text-center text-white-50 mb-4">Создайте аккаунт для продолжения</p>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="pb-4" id="register-form" action="{{route('register.store')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Фамилия</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="surname" class="form-label">Имя</label>
                        <input type="text" name="surname" id="surname" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Почта</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-light w-100 mt-4" type="submit">Зарегистрироваться</button>

                    <div class="text-center mt-4">
                        <p class="mb-0 text-white-50">Есть аккаунт? <a href="{{route('login')}}" class="fw-bold text-white">Войти</a></p>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
