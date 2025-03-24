@extends('layouts.app')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <main class="col-12 px-md-4">
                <h1 class="mb-3">Моё обучение</h1>
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="{{ route('userStudyMain.show', ['id' => $course->id]) }}">
                            Главная
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="{{ route('userStudyProgress.show', ['id' => $course->id]) }}">
                            Успеваемость
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="{{ route('userStudyTasks.show', ['id' => $course->id]) }}">
                            Задания
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card p-3" style="border: none;">
                                <h5 class="card-title">{{ $course->title ?? 'Не указано' }}</h5>
                                <a
                                    type="button"
                                    class="btn btn-primary"
                                    style="width: 50%"
                                    href="{{ route('courses.show', ['slug' => $course->slug]) }}"
                                >
                                    Продолжить обучение
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-3" style="border: none;">
                                <h5 class="card-title">Куратор</h5>
                                <p class="card-text">{{ $curator ? $curator->name : 'Куратор не назначен' }}</p>
                                <button class="btn btn-elprimary" style="width: 40%;">Написать сообщение</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-3">Активность</h4>
                        <div class="card p-3" style="border: none;"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
