@extends('layouts.app')

@section('main')
    @include('components.curator.course-header', ['active' => 'tasks'])

    <section class="mt-5">
        <form action="{{ route('curator.courses.tasks.update') }}">
            @csrf
        </form>
    </section>
@endsection
