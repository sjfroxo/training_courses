<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCourseRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'user_id' => ['required', 'exists:users,id'],
			'course_id' => ['required', 'exists:courses,id'],
			'progress' => ['integer', 'between:0,100'],
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
			'course_id.required' => 'Поле "Курс" обязательно для заполнения.',
			'course_id.exists' => 'Выбранный курс не существует.',
			'progress.required' => 'Поле "Прогресс" обязательно для заполнения.',
			'progress.integer' => 'Поле "Прогресс" должно быть целым числом.',
			'progress.min' => 'Значение поля "Прогресс" должно быть не менее 0.',
			'progress.max' => 'Значение поля "Прогресс" должно быть не более 100.',
		];
	}
}
