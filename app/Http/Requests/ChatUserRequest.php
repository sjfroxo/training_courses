<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required','exists:users,id'],
            'chat_id' => ['required','exists:chats,id'],
            'user_role' => ['required','string','in:user,administrator,moderator']
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Поле "Пользователь" обязательно для заполнения.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'chat_id.required' => 'Поле "Чат" обязательно для заполнения.',
            'chat_id.exists' => 'Выбранный чат не существует.',
            'user_role.required' => 'Поле "Роль пользователя" обязательно для заполнения.',
            'user_role.string' => 'Поле "Роль пользователя" должно быть строкой.',
            'user_role.in' => 'Неверная роль пользователя.',
        ];
    }
}
