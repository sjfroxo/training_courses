<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
	/**
	 *Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'title' => ['required', 'string', 'between:3,255', 'unique:user_roles,title'],
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
			'title.required' => 'Поле "Название роли" обязательно для заполнения.',
			'title.string' => 'Поле "Название роли" должно быть строкой.',
			'title.max' => 'Поле "Название роли" не должно превышать 255 символов.',
			'title.unique' => 'Роль с таким названием уже существует.',
		];
	}
}
