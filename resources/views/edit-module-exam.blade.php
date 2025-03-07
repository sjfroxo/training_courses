@extends('layouts.app')

@section('main')
    <div class="container mt-5">
        <h1>Редактирование теста</h1>

        <div id="questions">
            @foreach($questions as $index => $question)
                <div class="card mt-3 question" data-question-id="{{ $question->id }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text">Текст вопроса</label>
                            <input type="text" class="form-control" name="questions[{{ $index }}][text]"
                                   value="{{ $question->text }}" required>
                        </div>
                        <div class="form-group">
                            <label for="question_type_id">Тип вопроса</label>
                            <select class="form-control" name="questions[{{ $index }}][question_type_id]">
                                @foreach($questionTypes as $questionType)
                                    <option
                                            value="{{ $questionType->id }}" {{ $question->question_type_id == $questionType->id ? 'selected' : '' }}>{{ $questionType->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="questions[{{ $index }}][module_exam_id]"
                               value="{{ $moduleExam->id }}">
                        <div class="answers mt-3">
                            <label>Ответы</label>
                            @foreach($question->moduleExamAnswers as $answerIndex => $answer)
                                <div class="form-group answer mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox"
                                                       name="questions[{{ $index }}][answers][{{ $answerIndex }}][is_correct]"
                                                       value="1" {{ $answer->is_correct ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control"
                                               name="questions[{{ $index }}][answers][{{ $answerIndex }}][value]"
                                               value="{{ $answer->value }}" placeholder="Текст ответа">
                                        <button type="button" class="btn btn-danger removeAnswer"
                                                data-answer-id="{{ $answer->id }}">Удалить ответ
                                        </button>
                                        <button type="button" class="btn btn-primary updateAnswer"
                                                data-answer-id="{{ $answer->id }}">Обновить ответ
                                        </button>
                                    </div>
                                    <!-- Форма для обновления ответа -->
                                    <form class="answerUpdateForm"
                                          action="{{ route('moduleExamAnswers.update', $answer->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="value" value="{{ $answer->value }}">
                                        <input type="hidden" name="module_exam_question_id" value="{{ $question->id }}">
                                        <input type="hidden" name="is_correct" value="{{ $answer->is_correct }}">
                                        <input type="hidden" name="module_exam_id" value="{{ $moduleExam->id }}">
                                    </form>
                                </div>
                            @endforeach
                            <div class="buttons mt-3">
                                <button type="button" class="btn btn-secondary addAnswer"
                                        data-question-index="{{ $index }}">Добавить ответ
                                </button>
                                <form action="{{ route('moduleExamQuestion.destroy', $question->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger removeQuestion">Удалить вопрос</button>
                                </form>
                                <form action="{{ route('moduleExamQuestion.update', $question->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary updateQuestion">Обновить вопрос
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary" id="addQuestion">Добавить вопрос</button>
    </div>



    <script>
        const questionTypes = @json($questionTypes);
        const moduleExamId = {{ $moduleExam->id ?? 0 }};
        console.log('Module Exam ID:', moduleExamId);

        document.getElementById('addQuestion').addEventListener('click', function () {
            const questionsContainer = document.getElementById('questions');
            const questionIndex = questionsContainer.children.length;
            const questionTemplate = `
        <div class="card mt-3 question">
            <div class="card-body">
                <form class="questionForm" action="{{ route('moduleExamQuestion.store') }}" method="POST">
                    @csrf
            <div class="form-group">
                <label for="text">Текст вопроса</label>
                <input type="text" class="form-control" name="text" required>
            </div>
            <div class="form-group">
                <label for="question_type_id">Тип вопроса</label>
                <select class="form-control" name="question_type_id">
${questionTypes.map(questionType => `
                                <option value="${questionType.id}">${questionType.title}</option>
                            `).join('')}
                        </select>
                    </div>
                    <input type="hidden" name="module_exam_id" value="${moduleExamId}">
                    <div class="answers mt-3">
                        <div class="buttons mt-3">
                            <button type="button" class="btn btn-secondary addAnswer" data-question-index="${questionIndex}">Добавить ответ</button>
                            <button type="submit" class="btn btn-success saveQuestion">Сохранить вопрос</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `;
            questionsContainer.insertAdjacentHTML('beforeend', questionTemplate);
        });

        document.getElementById('questions').addEventListener('click', function (event) {
            if (event.target.classList.contains('addAnswer')) {
                const questionIndex = event.target.getAttribute('data-question-index');
                const answersContainer = event.target.closest('.answers');
                const answerIndex = answersContainer.querySelectorAll('.answer').length;
                const answerTemplate = `
            <div class="form-group answer mb-3">
                <div class="input-group">
                    <input type="text" required class="form-control" name="answers[${answerIndex}][value]" placeholder="Текст ответа">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" name="answers[${answerIndex}][is_correct]" value="1">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success saveAnswer">Сохранить ответ</button>
                </div>
                <form class="answerForm" action="{{ route('moduleExamAnswers.store') }}" method="POST" style="display: none;">
                    @csrf
                <input type="hidden" name="value" value="">
                <input type="hidden" name="is_correct" value="">
                <input type="hidden" name="module_exam_question_id" value="">
                <input type="hidden" name="module_exam_id" value="${moduleExamId}">
                </form>
            </div>
        `;
                answersContainer.insertBefore(document.createRange().createContextualFragment(answerTemplate), answersContainer.firstChild);
            } else if (event.target.classList.contains('removeAnswer')) {
                const answerId = event.target.getAttribute('data-answer-id');
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('moduleExamAnswers.destroy', '') }}/" + answerId;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            } else if (event.target.classList.contains('removeQuestion')) {
                const form = event.target.closest('form');
                form.submit();
            } else if (event.target.classList.contains('updateQuestion')) {
                const form = event.target.closest('form');
                const questionDiv = form.closest('.question');
                const textInput = questionDiv.querySelector('input[name^="questions"][name$="[text]"]');
                const typeSelect = questionDiv.querySelector('select[name^="questions"][name$="[question_type_id]"]');

                form.innerHTML = `
            @csrf
                @method('PATCH')
                <input type="hidden" name="text" value="${textInput.value}">
            <input type="hidden" name="question_type_id" value="${typeSelect.value}">
            <input type="hidden" name="module_exam_id" value="${moduleExamId}">
        `;

                form.submit();
            } else if (event.target.classList.contains('saveAnswer')) {
                const answerDiv = event.target.closest('.answer');
                const answerInput = answerDiv.querySelector('input[type="text"]');
                const isCorrectCheckbox = answerDiv.querySelector('input[type="checkbox"]');
                const answerForm = answerDiv.querySelector('.answerForm');

                console.log('Saving answer with:', {
                    value: answerInput.value,
                    isCorrect: isCorrectCheckbox.checked ? 1 : 0,
                    moduleExamQuestionId: event.target.closest('.question').getAttribute('data-question-id'),
                    moduleExamId: moduleExamId
                });

                answerForm.querySelector('input[name="value"]').value = answerInput.value;
                answerForm.querySelector('input[name="is_correct"]').value = isCorrectCheckbox.checked ? 1 : 0;
                answerForm.querySelector('input[name="module_exam_question_id"]').value = event.target.closest('.question').getAttribute('data-question-id');
                answerForm.querySelector('input[name="module_exam_id"]').value = moduleExamId;

                answerForm.submit();
            } else if (event.target.classList.contains('updateAnswer')) {
                const answerId = event.target.getAttribute('data-answer-id');
                const answerDiv = event.target.closest('.answer');
                const answerForm = answerDiv.querySelector('.answerUpdateForm');
                const isCorrectCheckbox = answerDiv.querySelector('input[type="checkbox"]');
                const answerInput = answerDiv.querySelector('input[type="text"]');

                answerForm.querySelector('input[name="value"]').value = answerInput.value;
                answerForm.querySelector('input[name="is_correct"]').value = isCorrectCheckbox.checked ? 1 : 0;

                answerForm.style.display = 'block';
                answerForm.submit();
            }
        });
    </script>
@endsection('main')
