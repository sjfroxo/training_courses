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
                                <div class="d-flex align-items-center mb-2">
                                    <img
                                        src="{{ $course->image_url ? asset('storage/' . $course->image_url) : asset('images/default_course.jpg') }}"
                                        alt="{{ $course->title }}"
                                        style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 10px;">
                                    <h5 class="card-title mb-0">{{ $course->title ?? 'Не указано' }}</h5>
                                </div>
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
                                <p class="card-text">{{ $curator ? $curator->name . ' ' . $curator->surname : 'Куратор не назначен' }}</p>
                                @if ($chat)
                                    <a href="{{ route('chats.index') }}?chat={{ $chat->slug }}" class="btn btn-elprimary" style="width: 40%;">Написать сообщение</a>
                                @else
                                    <p class="text-muted">Чат недоступен</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-3">Активность</h4>
                        <div class="calendar">
                            <div class="calendar-header">
                                <a href="{{ route(request()->route()->getName(), [Auth::id(), $course->id, $calendarData['prevMonth'], $calendarData['prevYear']]) }}" class="btn btn-sm btn-outline-secondary">&lt;</a>
                                <span>{{ $calendarData['firstDay']->format('F Y') }}</span>
                                <a href="{{ route(request()->route()->getName(), [Auth::id(), $course->id, $calendarData['nextMonth'], $calendarData['nextYear']]) }}" class="btn btn-sm btn-outline-secondary">&gt;</a>
                            </div>
                            <div class="calendar-body d-flex flex-wrap">
                                @foreach (['Пн','Вт','Ср','Чт','Пт','Сб','Вс'] as $day)
                                    <div class="text-center fw-bold" style="width: calc(100% / 7);">{{ $day }}</div>
                                @endforeach

                                @for ($i = 1; $i < $calendarData['startingDay']; $i++)
                                    <div style="width: calc(100% / 7);" class="p-2 text-center">&nbsp;</div>
                                @endfor

                                @for ($day = 1; $day <= $calendarData['daysInMonth']; $day++)
                                    @php
                                        $isActive = in_array($day, $calendarData['activeDays']);
                                    @endphp
                                    <div style="width: calc(100% / 7);" class="p-2 text-center rounded {{ $isActive ? 'bg-primary text-white' : '' }}">
                                        {{ $day }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
