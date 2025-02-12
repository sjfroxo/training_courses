{{--@extends('layouts.app')--}}

{{--@section('main')--}}
{{--    <div class="container mt-5">--}}
{{--        <h1>Создание нового теста</h1>--}}
{{--        <form id="testForm" action="{{route('moduleExam.store')}}" method='POST'>--}}
{{--            @csrf--}}
{{--            <div id="questions">--}}
{{--            </div>--}}
{{--            <button type="button" class="btn btn-primary" id="addQuestion">Добавить вопрос</button>--}}
{{--            <button type="submit" class="btn btn-success ">Сохранить тест</button>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        document.getElementById('addQuestion').addEventListener('click', function() {--}}
{{--            const questionsContainer = document.getElementById('questions');--}}
{{--            const questionIndex = questionsContainer.children.length;--}}
{{--            const questionTemplate = `--}}
{{--            <div class="card mt-3 question">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="questionText">Текст вопроса</label>--}}
{{--                        <input type="text" class="form-control" name="questions[${questionIndex}][questionText]" required>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="questionType">Тип вопроса</label>--}}
{{--                        <select class="form-control" name="questions[${questionIndex}][questionType]">--}}
{{--                            <option value="single">Одиночный ответ</option>--}}
{{--                            <option value="multiple">Множественный ответ</option>--}}
{{--                            <option value="text">Ответ в виде текста</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="answers mt-3">--}}
{{--                        <button type="button" class="btn btn-secondary addAnswer" data-question-index="${questionIndex}">Добавить ответ</button>--}}
{{--                        <button type="button" class="btn btn-danger removeQuestion">Удалить вопрос</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        `;--}}
{{--            questionsContainer.insertAdjacentHTML('beforeend', questionTemplate);--}}

{{--            const addAnswerButtons = document.querySelectorAll('.addAnswer');--}}
{{--            addAnswerButtons.forEach(button => {--}}
{{--                button.addEventListener('click', function() {--}}
{{--                    const questionIndex = this.getAttribute('data-question-index');--}}
{{--                    const answersContainer = this.parentElement;--}}
{{--                    const answerIndex = answersContainer.querySelectorAll('.answer').length;--}}
{{--                    const answerTemplate = `--}}
{{--                    <div class="form-group answer">--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="text" class="form-control" name="questions[${questionIndex}][answers][${answerIndex}]" placeholder="Текст ответа">--}}
{{--                            <button type="button" class="btn btn-danger removeAnswer">Удалить ответ</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                `;--}}
{{--                    answersContainer.insertAdjacentHTML('beforeend', answerTemplate);--}}

{{--                    const removeAnswerButtons = answersContainer.querySelectorAll('.removeAnswer');--}}
{{--                    removeAnswerButtons.forEach(removeButton => {--}}
{{--                        removeButton.addEventListener('click', function() {--}}
{{--                            const answerDiv = this.closest('.answer');--}}
{{--                            answerDiv.remove();--}}
{{--                        });--}}
{{--                    });--}}
{{--                });--}}
{{--            });--}}

{{--            const removeQuestionButtons = document.querySelectorAll('.removeQuestion');--}}
{{--            removeQuestionButtons.forEach(button => {--}}
{{--                button.addEventListener('click', function() {--}}
{{--                    const questionCard = this.closest('.question');--}}
{{--                    questionCard.remove();--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection('main')--}}
