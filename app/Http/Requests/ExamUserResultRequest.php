<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamUserResultRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required','exists:users,id'],
            'module_exam_question_id' => ['required','exists:module_exam_questions,id'],
            'mark' => ['required','integer','between:0,10'],
        ];
    }

    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Поле "Пользователь" обязательно для заполнения.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'module_exam_question_id.required' => 'Поле "Вопрос экзамена модуля" обязательно для заполнения.',
            'module_exam_question_id.exists' => 'Выбранный вопрос экзамена модуля не существует.',
            'mark.required' => 'Поле "Оценка" обязательно для заполнения.',
            'mark.integer' => 'Поле "Оценка" должно быть целым числом.',
            'mark.min' => 'Значение поля "Оценка" должно быть не менее 0.',
            'mark.max' => 'Значение поля "Оценка" должно быть не более 10.',
        ];
    }
}
