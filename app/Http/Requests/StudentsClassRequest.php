<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentsClassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения',
            'name.string' => 'Поле "Название" должно быть строкой',
            'user_id.required' => 'Поле "Пользователь" обязательно для заполнения.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
            'course_id.exists' => 'Выбранный курс не существует.',
        ];
    }
}
