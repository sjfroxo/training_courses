@extends('layouts.app')

@section('main')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 text-white" style="width: 400px; background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
            <div class="card-body">
                <h2 class="fw-bold text-center text-uppercase">Вход</h2>
                <p class="text-center text-white-50 mb-4">Введите свои данные для входа</p>

                <form id="login-form" action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Почта</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="#" class="small text-white-50">Забыли пароль?</a>
                    </div>

                    <button type="submit" class="btn btn-light w-100 mt-3">Войти</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('google.redirect') }}" class="btn btn-outline-light w-100">
                            <i class="fab fa-google"></i> Войти через Google
                        </a>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">Нет аккаунта?
                        <a href="{{ route('register') }}" class="text-white-50 fw-bold">Зарегистрироваться</a>
                    </p>
                </div>

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
