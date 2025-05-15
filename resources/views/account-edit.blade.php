@extends('layouts.app')

@section('main')
    <div class="container">
        <form
            action="{{ route('account.update') }}"
            enctype="multipart/form-data"
            method="POST"
        >
            @method('PATCH')
            @csrf
            <div class="form-group">
                <div style="width: 200px; height: 200px; border: 2px solid black; border-radius: 60px; overflow: hidden; margin: 20px">
                    <img id="uploaded-image" src="{{ getUserImage() }}" style="height: 100%;" alt="изображение пользователя">
                </div>
                <label for="avatar">Изменить аватар</label>
                <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Загрузить аватар">
            </div>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя"
                       value="{{$user->name}}">
            </div>
            <div class="form-group mb-2">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Введите фамилию"
                       value="{{$user->surname}}">
            </div>
            <button type="submit" class="btn btn-outline-primary">Подтвердить</button>
            <button type="button" class="btn btn-outline-secondary">Отменить</button>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.querySelector('input[type="file"]');
                const img = document.getElementById('uploaded-image');

                input.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = function (event) {
                        img.src = event.target.result;
                    };

                    reader.readAsDataURL(file);
                });
            });
        </script>
    </div>
@endsection
