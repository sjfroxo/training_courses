@extends('layouts.app')

@section('main')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100 w-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form class="mb-md-5 mt-md-4 pb-5" id="login-form" action="{{route('login.store')}}" method="POST">
                                @method('POST')
                                @csrf
                                <div class="mb-md-5 mt-md-4 pb-5">

                                    <h2 class="fw-bold mb-2 text-uppercase">Вход</h2>
                                    <p class="text-white-50 mb-5"></p>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="email">Почта</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg"/>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="password">Пароль</label>
                                        <input type="password"  name="password" id="password" class="form-control form-control-lg"/>
                                    </div>

                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#">Забыли пароль?</a>
                                    </p>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Войти</button>
                                    <a href="{{route('google.redirect')}}">
                                        Войти через гугл
                                    </a>

                                </div>

                                <div>
                                    <p class="mb-0">Нет аккаунта? <a href="{{route('register')}}"
                                                                     class="text-white-50 fw-bold">Зарегистрироваться</a>
                                    </p>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </section>

@endsection



{{--<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('login-form');
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });
        });
    });
</script>--}}
