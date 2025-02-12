<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleExamRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'module_id' => ['required', 'exists:modules,id'],
			'is_autochecked' => ['required', 'boolean'],
			'name' => ['required', 'string'],
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
			'module_id.required' => 'Поле "Модуль" обязательно для заполнения.',
			'module_id.exists' => 'Выбранный модуль не существует.',
			'is_autochecked.required' => 'Поле "Автоматическая проверка" обязательно для заполнения.',
			'is_autochecked.boolean' => 'Поле "Автоматическая проверка" должно быть логическим значением (true/false).',
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строковым значением.',
		];
	}
}
