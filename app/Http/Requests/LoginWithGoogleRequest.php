<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginWithGoogleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
			'name' => ['required', 'string', 'max:255'],
			'surname' => ['required', 'string', 'max:255'],
			'google_id' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле "Почта" обязательна для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.max' => 'Максимальное количество символов 255.',
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Максимальное количество символов 255.',
            'surname.required' => 'Поле "Фамилия" обязательно для заполнения.',
            'surname.string' => 'Поле "Фамилия" должно быть строкой.',
            'surname.max' => 'Максимальное количество символов 255.',
            'google_id.required' => 'Поле "Гугл айди" обязательна для заполнения.',
            'google_id.string' => 'Поле "Гугл айди" должно быть строкой.',
        ];
    }
}
