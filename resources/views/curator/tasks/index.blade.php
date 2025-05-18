@extends('layouts.app')

@section('main')
    <section class="w-100">

        @include('components.curator.course-header', ['active' => 'tasks'])

        @if (session()->has('success'))
            <div class="alert alert-success mt-5 w-25">
                {{ session()->get('success') }}
            </div>
        @endif

        <section class="mt-5">
            <a href="{{ route('curator.course.task.create') }}" class="btn btn-primary">
                Создать задание
                <span class="fw-bold">+</span>
            </a>


            <ul class="list-group mt-3 w-25">
                @forelse($tasks as $task)
                    <li class="list-group-item">
                        <div class="w-100 d-flex align-items-center justify-content-between">
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 7H20.5M5.5 13H20.5M5.5 19H14.5M2.5 25H23.5C24.3284 25 25 24.3284 25 23.5V2.5C25 1.67157 24.3284 1 23.5 1H2.5C1.67157 1 1 1.67157 1 2.5V23.5C1 24.3284 1.67157 25 2.5 25Z"
                                    stroke="#292929" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="m-0">{{ $task->name }}</p>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('curator.course.task.edit', $task->id) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.7999 15.5999L8.9999 19.1999M4.1999 15.5999L16.0313 3.35533C17.3052 2.08143 19.3706 2.08143 20.6445 3.35533C21.9184 4.62923 21.9184 6.69463 20.6445 7.96853L8.3999 19.7999L2.3999 21.5999L4.1999 15.5999Z"
                                            stroke="#292929" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                                <form action="{{ route('curator.course.task.destroy', $task->id) }}">
                                    <button type="submit" class="btn">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 10V16M14 10V16M18 6V18C18 19.1046 17.1046 20 16 20H8C6.89543 20 6 19.1046 6 18V6M4 6H20M15 6V5C15 3.89543 14.1046 3 13 3H11C9.89543 3 9 3.89543 9 5V6"
                                                stroke="#CD3232" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p
                            {{ \Carbon\Carbon::createFromDate($task->deadline)->lessThan(now()) ? 'class=text-danger' : '' }}
                        >
                            {{ $task->deadline_formatted }}
                        </p>
                    </li>
                @empty
                    <h1 class="alert-heading">У курса ещё нет практикантов!</h1>
                @endforelse
            </ul>
        </section>
    </section>
@endsection
