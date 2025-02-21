@extends('layouts.app')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <main class="col-12 px-md-4">
                <h1 class="mb-3">Моё обучение</h1>
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $section === 'home' ? 'active' : '' }}" href="{{ route('userStudy', 'home') }}">
                            Главная
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $section === 'progress' ? 'active' : '' }}" href="{{ route('userStudy', 'progress') }}">
                            Успеваемость
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $section === 'tasks' ? 'active' : '' }}" href="{{ route('userStudy', 'tasks') }}">
                            Задания
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ $section === 'home' ? 'show active' : '' }}"
                         id="home"
                         role="tabpanel"
                         aria-labelledby="home-tab">
                        <div class="row g-3">
                            <!-- Блок "Главная" -->
                            <div class="col-md-6">
                                <div class="card p-3" style="border: none; background-color: #fff;">
                                    <h5 class="card-title">Главная</h5>
                                    <p class="card-text">Здесь отображается информация о вашем обучении, текущие курсы и прогресс.</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-3" style="border: none; background-color: #fff;">
                                    <h5 class="card-title">Куратор</h5>
                                    <p class="card-text">Олег Петрович</p>
                                    <button class="btn btn-elprimary" style="width: 40%;">Написать сообщение</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="mb-3">Активность</h5>
                            <div class="card p-3" style="border: none; background-color: #fff;">
{{--                                {{ $calendarHtml }}--}}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $section === 'progress' ? 'show active' : '' }}"
                         id="progress"
                         role="tabpanel"
                         aria-labelledby="progress-tab">
                        <div class="card p-3" style="border: none; background-color: #fff;">
                            <h5 class="card-title">Успеваемость</h5>
                            <p class="card-text">Здесь вы можете увидеть свои результаты и статистику по курсам.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $section === 'tasks' ? 'show active' : '' }}"
                         id="tasks"
                         role="tabpanel"
                         aria-labelledby="tasks-tab">
                        <div class="card p-3" style="border: none; background-color: #fff;">
                            <h5 class="card-title">Задания</h5>
                            <p class="card-text">Список заданий, которые нужно выполнить в рамках курсов.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

@endsection
