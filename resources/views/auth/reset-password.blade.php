@extends('layouts.app')

@section('main')
    <div class="container d-flex justify-content-center align-items-center py-5 h-100">
        <div style="width: 400px;">
            <div class="card shadow-lg p-4 text-white" style="background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
                <div class="card-body">
                    <form class="pb-4" id="reset-form" action="{{ route('password.update') }}" method="POST">
                        @method('POST')
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <h2 class="fw-bold text-center text-uppercase mb-4">Восстановление пароля</h2>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Почта</label>
                            <input type="email" name="email" value="{{ old('email') }}" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Введите почту" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Новый пароль</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Введите новый пароль" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Подтвердите новый пароль" required>
                        </div>

                        <button class="btn btn-light w-100 mt-4" type="submit">Восстановить</button>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-white-50">Не помните токен? <a href="{{ route('login') }}"
                                                                               class="fw-bold text-white">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
