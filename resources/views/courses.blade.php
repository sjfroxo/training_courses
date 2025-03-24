@extends('layouts.app')

@section('main')
    <div class="container d-flex flex-column" style="height: 100%; width: 60%; background-color: transparent;">
        @include('layouts.navigation')

        <div class="content flex-grow-1">
            <div class="card-header rounded-top-4" style="background-color: transparent; border: none;">

            </div>
            <div class="card-body" style="margin: 0 auto; background-color: transparent;">
                <h2 class="mb-3">Курсы</h2>
                @can('create', \App\Models\Course::class)
                    <div class="mb-3">
                        <x-add-button-invert route="{{ route('courses.create') }}"/>
                    </div>
                @endcan
                <div class="d-flex flex-column justify-content-center align-items-center">
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
{{--                    @dd($course->id)--}}
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center"
             style="position: fixed; bottom: 20px; width: 80%; background-color: transparent;">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
