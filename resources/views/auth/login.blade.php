@extends('layouts.app')

@section('main')
    <div class="container d-flex justify-content-center align-items-center py-5 h-100">
        <div class="card shadow-lg p-4 text-white" style="width: 400px; background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
            <div class="card-body">
                <h2 class="fw-bold text-center text-uppercase">Вход</h2>
                <p class="text-center text-white-50 mb-4">Введите свои данные для входа</p>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="login-form" action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Почта</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-white-50" for="remember">Запомнить меня</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('password.request') }}" class="small text-white-50">Забыли пароль?</a>
                    </div>

                    <button type="submit" class="btn btn-light w-100 mt-4">Войти</button>

                    <div class="text-center mt-4">
                        <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-light w-100">
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
