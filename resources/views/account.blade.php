@extends('layouts.app')

@section('main')
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="{{ getUserImage() }}" alt="avatar" class="rounded-circle" width="150" height="150">
                <div class="mt-3">
                    <h4>{{$user->name}} {{$user->surname}}</h4>
                    <p class="text-secondary mb-1">{{ \App\Enums\UserRoleEnum::tryFrom($user->user_role_id)->title() }}</p>
                    <a href="{{ route('account.edit') }}" class="btn btn-primary">Редактировать</a>
                    <a href="{{ route('logout') }}" class="btn btn-elprimary">Выход</a>
                </div>
            </div>
        </div>
    </div>
@endsection
