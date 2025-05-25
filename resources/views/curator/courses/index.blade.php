@extends('layouts.app')

@section('main')
    <section class="w-100">
        @if (session()->has('success'))
            <div class="alert alert-success mt-5 w-25">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger mt-5 w-25">
                {{ session()->get('error') }}
            </div>
        @endif


        <x-curator.course-header :title="$title"></x-curator.course-header>

        <ul class="list-group mt-5 gap-4">
            @forelse($courses as $course)
                <li class="list-group-item">
                    <img src="{{ asset($course->image_url) }}" alt="{{ $course->title }}"
                         style="width: 20px; height: 20px; border-radius: 5px;"
                    >
                    <h1>{{ $course->title }}</h1>
                    <p>{{ $course->description }}</p>
                </li>
            @empty
                <h1>У вас нет курсов!</h1>
            @endforelse
        </ul>
    </section>
@endsection
