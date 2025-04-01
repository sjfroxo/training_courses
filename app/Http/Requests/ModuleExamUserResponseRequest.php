<?php

namespace App\Http\Requests;

use App\Models\ModuleExamQuestion;
use Illuminate\Foundation\Http\FormRequest;

class ModuleExamUserResponseRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'question_id' => ['required', 'array'],
			'question_id.*' => ['required', 'exists:module_exam_questions,id'],
			'answer' => ['required', 'array'],
			'answer.*' => ['nullable', function($attribute, $value, $fail) {
				$questionId = str_replace('answer.', '', $attribute);
				$question = ModuleExamQuestion::query()->find($questionId);
				if($question->questionType->id === 3 && !is_numeric($value)) {
					$fail('Для вопроса с типом 3 ожидается один выбранный ответ.');
				} elseif($question->questionType->id === 2 && !is_array($value)) {
					$fail('Для вопроса с типом 2 ожидается массив выбранных ответов.');
				} elseif($question->questionType->id === 1 && !is_string($value)) {
					$fail('Для вопроса с типом 1 ожидается текстовый ответ.');
				}
			}],
			'answer.*.*' => ['nullable', 'exists:module_exam_answers,id'],
            'module_exam_id' => ['required', 'string', 'exists:module_exams,id'],
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
            'module_exam_answer_id.exists' => 'Выбранный ответ на вопрос экзамена модуля не существует.',
            'module_exam_id.required' => 'Поле "Тест" обязательно для заполнения',
            'module_exam_id.sting' => 'Поле "Тест" должно быть строкой',
            'module_exam_id.exists' => 'Выбранный тест не существует',
			'question_id.required' => 'Поле "Вопрос" обязательно для заполнения.',
			'question_id.exists' => 'Выбранный вопрос не существует.',
			'user_id.required' => 'Поле "Пользователь" обязательно для заполнения.',
			'user_id.exists' => 'Выбранный пользователь не существует.',
			'text.required' => 'Поле "Текст ответа" обязательно для заполнения.',
			'text.string' => 'Поле "Текст ответа" должно быть строкой.',
		];
	}
}
