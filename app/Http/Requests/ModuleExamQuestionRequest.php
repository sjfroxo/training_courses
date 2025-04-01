<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleExamQuestionRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'text' => ['required', 'string'],
			'module_exam_id' => ['required', 'string', 'exists:module_exams,id'],
			'question_type_id' => ['required', 'string', 'exists:question_types,id'],
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
			'text.required' => 'Поле "Текст вопроса" обязательно для заполнения.',
			'text.string' => 'Поле "Текст вопроса" должно быть строкой.',
			'module_exam_id.required' => 'Поле "Экзамен модуля" обязательно для заполнения.',
            'module_exam_id.string' => 'Поле "Экзамен модуля" должно быть строкой.',
			'module_exam_id.exists' => 'Выбранный экзамен модуля не существует.',
			'question_type_id.required' => 'Поле "Тип вопроса" обязательно для заполнения.',
            'question_type_id.string' => 'Поле "Тип вопроса" должно быть строкой.',
			'question_type_id.exists' => 'Выбранный тип вопроса не существует.',
		];
	}
}
