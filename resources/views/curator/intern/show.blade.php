@extends('layouts.app')

@section('main')
    <section class="w-100 m-lg-5">
        <div class="d-flex gap-4 align-items-center">
            <div style="
                                width: 36px;
                                height: 36px;
                                background-color: #513DEB;
                                color: white;
                                display:flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 10px;
                            ">
                {{ mb_strtoupper($intern->name[0]) }}
            </div>
            <h2>{{ $intern->name }} {{ $intern->surname }}</h2>
        </div>

        <ul class="list-group d-flex w-100">
            @forelse($tasks as $task)
                <div class="w-25">
                    <li class="list-group-item">
                        <div class="w-100 d-flex align-items-center justify-content-between">
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 7H20.5M5.5 13H20.5M5.5 19H14.5M2.5 25H23.5C24.3284 25 25 24.3284 25 23.5V2.5C25 1.67157 24.3284 1 23.5 1H2.5C1.67157 1 1 1.67157 1 2.5V23.5C1 24.3284 1.67157 25 2.5 25Z"
                                    stroke="#292929" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="m-0">{{ $task->name }}</p>
                        </div>
                        <p {{ \Carbon\Carbon::createFromDate($task->deadline)->lessThan(now()) ? 'class=text-danger' : '' }}>{{ $task->deadline_formatted }}</p>
                    </li>
                </div>
            @empty
                <h1>Этот учащийся пока ничего не сдавал</h1>
            @endforelse
        </ul>
    </section>
@endsection
