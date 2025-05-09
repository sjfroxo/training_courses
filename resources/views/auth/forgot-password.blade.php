@extends('layouts.app')

@section('main')
    <div class="container d-flex justify-content-center align-items-center py-5 h-100">
        <div style="width: 400px;">
            <div class="card shadow-lg p-4 text-white" style="background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
                <div class="card-body">
                    <h2 class="fw-bold text-center text-uppercase mb-4">Восстановление пароля</h2>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="reset-form" action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Почта</label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Введите почту"
                                   required>

                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('login') }}" class="small text-white-50">Назад</a>
                        </div>
                        <button type="submit" class="btn btn-light w-100 mt-4">Отправить</button>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-white-50">Помните пароль? <a href="{{ route('login') }}"
                                                                             class="fw-bold text-white">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
