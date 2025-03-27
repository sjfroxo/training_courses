@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4" style="border: none;">
            <div style="display: flex; flex-direction: column;">
                <h2 class="m-3">Пользователи</h2>
                <a type="button" class="btn btn-primary m-3 mt-0" style="width: 20%" href="{{route('users.create')}}">Создать пользователя +</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата создания</th>
                            <th>Имя и Фамилия</th>
                            <th>Электронная почта</th>
                            <th>Статус</th>
                            <th>Роль</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->id }}</a></td>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->created_at }}</a></td>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }} {{ $user->surname }}</a></td>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->email }}</a></td>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}"></a></td>
                                <td><a style="text-decoration: none; color: #000;" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->role->title }}</a></td>
                                <td>
                                    <a style="text-decoration: none; color: #4e4e4e; margin-right: 10px;" href="{{ route('users.edit', ['user' => $user->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </a>
                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy',['user' => $user->id]) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-delete-button/>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
