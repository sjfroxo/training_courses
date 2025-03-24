@extends('layouts.app')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <main class="col-12 px-md-4">
                <h1 class="mb-3">Моё обучение</h1>
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link"
                           href="{{ route('userStudyMain.show', ['id' => $course->id]) }}">
                            Главная
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link"
                           href="{{ route('userStudyProgress.show', ['id' => $course->id]) }}">
                            Успеваемость
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link"
                           href="{{ route('userStudyTasks.show', ['id' => $course->id]) }}">
                            Задания
                        </a>
                    </li>
                </ul>
                <h4>Тесты</h4>
                <div class="card p-3" style="border: solid 1px #c1c1c1; display: flex; align-items: center">
                    <p>Количество тестов</p>
                    <h4>{{ $totalCountCourses }}</h4>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Процент пройденных тестов</p>
                        <h4>{{ $progress }}%</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>

                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Процент не пройденных тестов</p>
                        <h4>{{ 100 - $progress }}%</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>

                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Средний балл за тесты</p>
                        <h4>{{ $averageUserScore }}</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>
                </div>

                <h4 style="margin-top: 40px;">Домашние задания</h4>
                <div class="card p-3" style="border: solid 1px #c1c1c1; display: flex; align-items: center">
                    <p>Количество домашних заданий</p>
                    <h4>{{ $totalCountCourses }}</h4>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Процент выполненных домашних заданий</p>
                        <h4>{{ $progress }}%</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>

                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Процент не выполненных домашних заданий</p>
                        <h4>{{ 100 - $progress }}%</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>

                    <div class="card p-3 col-md-3" style="border: solid 1px #c1c1c1;">
                        <p>Средний балл</p>
                        <h4>{{ $averageUserScore }}</h4>
                        <p style="color: #888888; font-size: 13px;">За последние 4 недели</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
