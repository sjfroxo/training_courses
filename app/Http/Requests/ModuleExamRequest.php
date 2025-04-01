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
			'module_id' => ['required', 'string', 'exists:modules,id'],
			'is_autochecked' => ['required', 'string', 'boolean'],
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
            'module_id.string' => 'Поле "Модуль" должно быть строковым значением.',
			'module_id.exists' => 'Выбранный модуль не существует.',
			'is_autochecked.required' => 'Поле "Автоматическая проверка" обязательно для заполнения.',
            'is_autochecked.string' => 'Поле "Автоматическая проверка" должно быть строковым значением.',
			'is_autochecked.boolean' => 'Поле "Автоматическая проверка" должно быть логическим значением (true/false).',
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строковым значением.',
		];
	}
}
