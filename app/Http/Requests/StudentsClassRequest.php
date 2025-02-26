<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use App\Models\StudentsClass;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            'curator_id' => ['required', 'exists:users,id', 'integer'],
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['exists:users,id', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения',
            'name.string' => 'Поле "Название" должно быть строкой',
            'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
            'course_id.exists' => 'Выбранный курс не существует.',
            'curator_id.required' => 'Поле "Куратор" обязательно для заполнения.',
            'curator_id.exists' => 'Выбранный куратор не существует.',
            'student_ids.required' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.array' => 'Ученики должны быть списком.',
            'student_ids.min' => 'Необходимо выбрать хотя бы одного ученика.',
            'student_ids.*.exists' => 'Один или несколько выбранных учеников не существуют.',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param null $key
     * @param null $default
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();

        $curator = User::query()->findOrFail($validated['curator_id']);
        if ($curator->user_role_id !== UserRoleEnum::CURATOR->value) {
            throw ValidationException::withMessages([
                'curator_id' => ['Выбранный куратор должен иметь роль "Куратор".'],
            ]);
        }

        foreach ($validated['student_ids'] as $studentId) {
            $student = User::query()->findOrFail($studentId);
            if ($student->user_role_id !== UserRoleEnum::USER->value) {
                throw ValidationException::withMessages([
                    'student_ids' => ['Все выбранные ученики должны иметь роль "Пользователь".'],
                ]);
            }
        }

        return $validated;
    }
}
