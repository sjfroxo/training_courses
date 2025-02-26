@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                Пользователи
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Статус</th>
                            <th>Почта</th>
                            <th>Тестов пройдено:</th>
                            <th>Тестов не пройдено:</th>
                            <th>Средний балл по тестам</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->role->title }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $numberPassedCourseExamsByUsers[$user->id] ?? 0 }}
                                    ({{ $percentPassedCourseExams[$user->id] ?? 0 }}%)
                                </td>
                                <td>{{ ($numberCourseExams - ($numberPassedCourseExamsByUsers[$user->id] ?? 0)) }}
                                    ({{ (100 - ($percentPassedCourseExams[$user->id] ?? 0)) }}%)
                                </td>
                                <td>{{ $averageMark[$user->id] ?? 'Нет данных' }}</td>
                                <td>
                                    <a type="button" class="btn btn-success"
                                       href="{{ route('users.show', ['user' => $user->id]) }}">Подробнее</a>
{{--                                    @if(Auth::check() && Auth::user()->isAdministrator())--}}
{{--                                        <a type="button" class="btn btn-success mt-2"--}}
{{--                                           href="{{ route('admin.user.activity', [$user->id, $course->id]) }}">Активность</a>--}}
{{--                                    @endif--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
