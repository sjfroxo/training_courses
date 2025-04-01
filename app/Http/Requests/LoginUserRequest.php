<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'email' => ['required', 'email'],
			'password' => ['required', 'string'],
		];
	}

    public function messages(): array
    {
        return [
            'email.required' => 'Почта обязательна для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
        ];
    }
}
