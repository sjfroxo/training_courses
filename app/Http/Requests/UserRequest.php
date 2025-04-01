<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'between:2,255'],
			'surname' => ['required', 'string', 'between:2,255'],
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
			'name.required' => 'Поле "Имя" обязательно для заполнения.',
			'name.string' => 'Поле "Имя" должно быть строкой.',
			'name.max' => 'Поле "Имя" не должно быть меньше 2 и превышать 255 символов.',
			'surname.required' => 'Поле "Фамилия" обязательно для заполнения.',
			'surname.string' => 'Поле "Фамилия" должно быть строкой.',
			'surname.max' => 'Поле "Фамилия" не должно быть меньше 2 и превышать 255 символов.',
			'email.required' => 'Поле "Email" обязательно для заполнения.',
			'email.string' => 'Поле "Email" должно быть строкой.',
			'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты.',
			'email.max' => 'Поле "Email" не должно превышать 255 символов.',
			'email.unique' => 'Пользователь с таким Email уже существует.',
			'password.required' => 'Поле "Пароль" обязательно для заполнения.',
			'password.string' => 'Поле "Пароль" должно быть строкой.',
			'password.min' => 'Поле "Пароль" должно содержать не менее 8 символов.',
			'user_role_id.required' => 'Поле "Роль пользователя" обязательно для заполнения.',
			'user_role_id.exists' => 'Выбранная роль пользователя не существует.',
		];
	}
}
