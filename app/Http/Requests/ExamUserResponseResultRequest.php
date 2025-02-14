<?php

namespace App\Http\Requests;

use App\Models\ModuleExamQuestion;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExamUserResponseResultRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        try {

            return [
                'question_id' => ['required', 'array'],
                'question_id.*' => ['required', 'exists:module_exam_questions,id'],
                'answer' => ['required', 'array'],
                'answer.*' => ['nullable', function($attribute, $value, $fail) {
                    $questionId = str_replace('answer.', '', $attribute); // todo переделать чтобы не было answer. а просто число
                    $question = ModuleExamQuestion::query()->with('questionType')->find($questionId);

                    if ($question->questionType->id === 3 && !is_numeric($value)) {
                        $fail('Для вопроса с типом 3 ожидается один выбранный ответ.');
                    } elseif ($question->questionType->id === 2 && !is_array($value)) {
                        $fail('Для вопроса с типом 2 ожидается массив выбранных ответов.');
                    } elseif ($question->questionType->id === 1 && !is_string($value)) {
                        $fail('Для вопроса с типом 1 ожидается текстовый ответ.');
                    }
                }],
//
//                'answer.*.*' => ['nullable', 'exists:module_exam_answers,id'],
                'module_exam_id' => ['required', 'numeric', 'exists:module_exams,id'],
                'user_id' => ['required', 'numeric', 'exists:users,id'],
//                'module_exam_question_id' => ['required','exists:module_exam_questions,id'],
                'mark' => ['nullable','integer','between:0,10'],
            ];
        } catch (\Exception $e) {dd($e);}
    }

    public function messages(): array
    {
        return [
            'module_exam_answer_id.exists' => 'Выбранный ответ на вопрос экзамена модуля не существует.',
            'module_exam_id.required' => 'Поле "Тест" обязательно для заполнения',
            'module_exam_id.exists' => 'Выбранный тест не существует',
            'question_id.required' => 'Поле "Вопрос" обязательно для заполнения.',
            'question_id.exists' => 'Выбранный вопрос не существует.',
            'user_id.required' => 'Поле "Пользователь" обязательно для заполнения.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'text.required' => 'Поле "Текст ответа" обязательно для заполнения.',
            'text.string' => 'Поле "Текст ответа" должно быть строкой.',
            'module_exam_question_id.required' => 'Поле "Вопрос экзамена модуля" обязательно для заполнения.',
            'module_exam_question_id.exists' => 'Выбранный вопрос экзамена модуля не существует.',
            'mark.required' => 'Поле "Оценка" обязательно для заполнения.',
            'mark.integer' => 'Поле "Оценка" должно быть целым числом.',
            'mark.min' => 'Значение поля "Оценка" должно быть не менее 0.',
            'mark.max' => 'Значение поля "Оценка" должно быть не более 10.',
        ];
    }
}
