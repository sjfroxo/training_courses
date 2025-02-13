@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                Пользователи
                <a type="button" class="btn btn-primary" href="{{route('users.create')}}">Добавить</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Имя Фамилия</th>
                            <th>Почта</th>
                            <th>Номер телефона</th>
                            <th>Роль</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }} {{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td></td>
                                <td>{{ $user->role->title }}</td>
                                <td>
                                    <a type="button" class="btn btn-primary" href="{{ route('users.show', ['user' => $user->id]) }}">info</a>
                                    <a type="button" class="btn btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}">edit</a>
                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy',['user' => $user->id]) }}" method="POST" style="display: inline;">
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
