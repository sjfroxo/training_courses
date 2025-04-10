@extends('layouts.app')

@section('main')
    <div class="container d-flex justify-content-center align-items-center py-5 h-100">
        <div class="card shadow-lg p-4 text-white" style="width: 400px; background: rgba(0, 0, 0, 0.8); border-radius: 15px;">
            <div class="card-body">
                <h2 class="fw-bold text-center text-uppercase">Восстановление пароля</h2>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="login-form" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Почта</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-light w-100 mt-4">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
