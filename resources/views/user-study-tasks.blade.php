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
                <div class="card p-3" style="border: none; display: flex; align-items: center;">
                    <h3 class="card-title">Домашних заданий нет</h3>
                    <p class="card-text">Здесь будут появляться задания от вашего куратора</p>
                </div>
            </main>
        </div>
    </div>
@endsection
