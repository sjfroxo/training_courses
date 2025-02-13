@extends('layouts.app')

@section('main')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('examUserResponseResult.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="module_exam_id" value="{{ $moduleExam->id }}">
                            <input type="hidden" name="user_id" value="{{auth()->id() }}">
                            <input type="hidden" name="questionsCount" value="{{ $a = 0 }}">

                            @foreach($questions as $question)
                                <h5 class="card-title">Вопрос {{$loop->iteration}}</h5>
                                <p class="card-text">{{$question->text}}</p>
                                <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                @if($question->questionType->id === 3)
                                    <ul class="list-group list-group-flush">
                                        @foreach($question->moduleExamAnswers as $examAnswer)
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="answer[{{$question->id}}]"
                                                           id="option{{$question->id}}_{{$examAnswer->id}}" required
                                                           value="{{$examAnswer->id}}">
                                                    <label class="form-check-label"
                                                           for="option{{$question->id}}_{{$examAnswer->id}}">
                                                        {{$examAnswer->value}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif($question->questionType->id === 2)
                                    <ul class="list-group">
                                        @foreach($question->moduleExamAnswers as $examAnswer)
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="answer[{{$question->id}}][]"
                                                           id="option{{$question->id}}_{{$examAnswer->id}}"
                                                           value="{{$examAnswer->id}}">
                                                    <label class="form-check-label"
                                                           for="option{{$question->id}}_{{$examAnswer->id}}">
                                                        {{$examAnswer->value}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="mb-3">
                                        <label for="answer{{$question->id}}" class="form-label">Ваш ответ:</label>
                                        <input type="text" class="form-control" id="answer{{$question->id}}"
                                               name="answer[{{$question->id}}]" required>
                                    </div>
                                @endif
                                <input type="hidden" name="questionsCount" value="{{ $a++ }}">
                            @endforeach
                            <p>Всего вопросов: {{ $a }}</p>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <h5>Отправить</h5>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
