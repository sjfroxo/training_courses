@extends('layouts.app')

@section('main')
    <section class="gradient-custom">
        <div class="container d-flex justify-content-center align-items-center py-5 h-100">
            <div style="width: 500px;">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form class="pb-4" id="register-form" action="{{ route('password.update') }}"
                              method="POST">
                            @method('POST')
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <h2 class="fw-bold mb-2 text-uppercase">Восстановление пароля</h2>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="email">Почта</label>
                                <input type="email" name="email" value="{{ old('email') }}" id="email"
                                       class="form-control form-control-lg
                                       input @error('email') ring-red-500 @enderror"/>
                                @error('email')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="password">Пароль</label>
                                <input type="password" name="password" id="password"
                                       class="form-control form-control-lg"/>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="password_confirmation">Подтвердите пароль</label>
                                <input type="password" name="password_confirmation" id="password"
                                       class="form-control form-control-lg"/>
                            </div>

                            <button class="btn btn-outline-light btn-lg px-5" type="submit">Восстановить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

