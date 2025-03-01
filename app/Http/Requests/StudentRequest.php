<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_ids' => ['required', 'array', 'min:1', 'max:30'],
            'student_ids.*' => ['exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_ids.required' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.array' => 'Ученики должны быть списком.',
            'student_ids.min' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.max' => 'Максимум можно выбрать 30 учеников.',
            'student_ids.*.exists' => 'Один или несколько выбранных учеников не существуют.',
        ];
    }
}
