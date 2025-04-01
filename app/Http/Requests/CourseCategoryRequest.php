<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'string', 'exists:categories,id'],
            'course_id' => ['required', 'string', 'exists:courses,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Поле "Категория" обязательно для заполнения.',
            'category_id.string' => 'Поле "Категория" должно быть строкой.',
            'category_id.exists' => 'Выбранная категория не существует.',
            'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
            'course_id.string' => 'Поле "Курс" должно быть строкой.',
            'course_id.exists' => 'Выбранный курс не существует.',
        ];
    }
}
