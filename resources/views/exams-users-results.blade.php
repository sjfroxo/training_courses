@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Результаты теста</h1>
        <p>Тест: {{ $moduleExam->name }}</p>
        <p>Правильных ответов: {{ $results['correct'] }} из {{ $results['total'] }}</p>
        <p>Оценка: {{ $results['percent'] }}</p>
        <a type="button" class="btn btn-elprimary" href="{{ route('courses') }}">Участники</a>
    </div>
@endsection
