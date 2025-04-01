<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
			'email' => ['required', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', Password::defaults()],
		];
	}

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.string' => 'Поле "Имя" должно быть строкой',
            'name.between' => 'Поле "Имя" не должно быть короче 2 и больше 255.',
            'surname.required' => 'Поле "Имя" обязательно для заполнения',
            'surname.string' => 'Поле "Фамилия" должно быть строкой',
            'surname.between' => 'Поле "Фамилия" не должно быть короче 2 и больше 255.',
            'email.required' => 'Поле "Почта" обязательно для заполнения',
            'email.email' => 'Введите корректное значение поле "Почта"',
            'email.max' => 'Поле "Почта" не должно превышать 255.',
            'email.unique' => 'Поле "Почта" должно быть уникальным.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.string' => 'Поле "Пароль" должно быть строкой',
        ];
    }
}
