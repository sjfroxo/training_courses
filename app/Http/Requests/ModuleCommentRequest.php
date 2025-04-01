<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'module_id' => ['required', 'string', 'exists:modules,id'],
            'text' => ['required','string'],
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
            'user_id.string' => 'Поле "Пользователь" должно быть строкой.',
            'module_id.required' => 'Поле "Модуль" обязательно для заполнения.',
            'module_id.string' => 'Поле "Пользователь" должно быть строкой.',
            'module_id.exists' => 'Выбранный модуль не существует.',
            'text.required' => 'Поле "Текст комментария" обязательно для заполнения.',
            'text.string' => 'Поле "Текст комментария" должно быть строкой.',
        ];
    }
}
