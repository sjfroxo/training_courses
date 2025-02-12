<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','between:3,255'],
            'course_id' => ['required','exists:courses,id'],
            'content' => ['required','string'],
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
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'title.string' => 'Поле "Название" должно быть строкой.',
            'title.max' => 'Поле "Название" не должно превышать 255 символов.',
            'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
            'course_id.exists' => 'Выбранный курс не существует.',
            'content.required' => 'Поле "Содержание" обязательно для заполнения.',
            'content.string' => 'Поле "Содержание" должно быть строкой.',
        ];
    }
}
