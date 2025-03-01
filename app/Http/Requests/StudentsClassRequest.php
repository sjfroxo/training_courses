<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StudentsClassRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'exists:courses,id'],
            'curator_id' => ['required', 'exists:users,id'],
            'student_ids' => ['required', 'array', 'min:1', 'max:30'],
            'student_ids.*' => ['exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения.',
            'name.string' => 'Поле "Название" должно быть строкой.',
            'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
            'course_id.exists' => 'Выбранный курс не существует.',
            'curator_id.required' => 'Поле "Куратор" обязательно для заполнения.',
            'curator_id.exists' => 'Выбранный куратор не существует.',
            'student_ids.required' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.array' => 'Ученики должны быть списком.',
            'student_ids.min' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.max' => 'Максимум можно выбрать 30 учеников.',
            'student_ids.*.exists' => 'Один или несколько выбранных учеников не существуют.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $curator = User::query()->find($this->input('curator_id'));
            if ($curator && $curator->user_role_id !== UserRoleEnum::CURATOR->value) {
                $validator->errors()->add('curator_id', 'Выбранный куратор должен иметь роль "Куратор".');
            }

            foreach ($this->input('student_ids', []) as $studentId) {
                $student = User::query()->find($studentId);
                if ($student && $student->user_role_id !== UserRoleEnum::USER->value) {
                    $validator->errors()->add('student_ids', 'Все выбранные ученики должны иметь роль "Пользователь".');
                    break;
                }
            }
        });
    }
}
