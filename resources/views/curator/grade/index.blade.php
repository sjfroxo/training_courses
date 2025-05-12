@extends('layouts.app')

@section('main')
    <section class="w-100">

        @include('components.curator.course-header', ['active' => 'grades'])

        <table class="table table-bordered table-striped text-center align-middle mt-5">
            <thead class="table-light">
            <tr>
                <th>Студенты</th>
                <th>Оценка</th>
                <th>Задание</th>
            </tr>
            </thead>
            <tbody>
            @foreach($answers as $answer)
                <tr>
                    <td>{{ $answer->user->name }} {{ $answer->user->surname }}</td>
                    <td>
                        <p class="m-0">
                            @if (\App\Enums\TaskAnswerStatusEnum::DONE->value === $answer->status)
                                Оценка: {{ $answer->grade }}
                            @else
                                {{ \App\Enums\TaskAnswerStatusEnum::tryFrom($answer->status)->title() }}
                            @endif
                        </p>

                        @if (
                            \Carbon\Carbon::parse($answer->task->deadline)->lessThan(now()) &&
                            \App\Enums\TaskAnswerStatusEnum::INTERN_FREE->value !== $answer->status
                        )
                            <p class="m-0"><small class="text-danger">Пропущен срок сдачи</small></p>
                        @endif
                    </td>
                    <td>{{ $answer->task->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
