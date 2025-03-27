@extends('layouts.app')

@section('main')
    <div class="container d-flex flex-column" style="height: 100%; width: 60%; background-color: transparent; margin-top: 5%;">
        @include('layouts.navigation')

        <div class="content flex-grow-1">
            <div class="card-header rounded-top-4" style="background-color: transparent; border: none;"></div>
            <div class="card-body" style="margin: 0 auto; background-color: transparent;">
                <h2 class="mb-3">Курсы</h2>
                @can('create', \App\Models\Course::class)
                    <div class="mb-3">
                        <x-add-button-invert route="{{ route('courses.create') }}"/>
                    </div>
                @endcan
                <div class="d-flex flex-column justify-content-center align-items-center">
                    @if($courses->total() > 0)
                        @foreach($courses as $course)
                            @can('view', $course)
                                <div class="mb-4" style="width: 100%; background-color: transparent;">
                                    @include('components.course-card', [
                                        'title' => $course->title,
                                        'description' => $course->description,
                                        'course' => $course,
                                        'deleteForm' => route('courses.destroy', $course->id),
                                    ])
                                </div>
                            @endcan
                        @endforeach
                    @else
                        <div style="height: 100%;">
                            @if(auth()->user()->isAdministrator())
                                <h3>Страница курсов</h3>
                                <p>Добавляйте курсы для студентов, составляйте программу, тесты и т. д.</p>
                            @else
                                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%; margin-top: 50%;">
                                    <h3>Учебные курсы пока недоступны</h3>
                                    <p>Учебные курсы будут добавлены администратором</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center" style="position: fixed; bottom: 20px; width: 80%; background-color: transparent;">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
