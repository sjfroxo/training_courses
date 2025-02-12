@extends('layouts.app')

@section('main')
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                <div class="mt-3">
                    <h4>{{$user->name}} {{$user->surname}}</h4>
                    <p class="text-secondary mb-1">{{$user->user_role}}</p>
                    <a href="{{ route('account.edit', ['id' => auth()->id()]) }}" class="btn btn-primary">Редактировать</a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-primary">Выход</a>
                </div>
            </div>
        </div>
    </div>
@endsection
