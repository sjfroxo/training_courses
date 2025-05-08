<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChatMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isMethod('PUT')) {
            return [
                'message'    => ['required', 'string'],
                'media_file' => ['nullable', 'file', 'mimes:webm,mkv,mp3,mp4,jpg,png', 'max:10240'],
            ];
        } else {
            return [
                'chat_id' => ['required', 'integer', 'exists:chats,id'],
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'type' => ['required', 'string', 'in:text,voice,video'],
                'message' => ['string', 'nullable'],
                'reply_message_id' => ['nullable', 'integer', 'exists:chat_messages,id'],
                'media_file' => ['nullable', 'file', 'mimes:webm,mkv,mp3,mp4,jpg,png', 'max:10240'],
            ];
        }
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'chat_id.required' => 'Чат обязателен для заполнения.',
            'chat_id.integer' => 'ID чата должен быть числом.',
            'chat_id.exists' => 'Выбранный чат не существует.',
            'user_id.required' => 'Пользователь обязателен для заполнения.',
            'user_id.integer' => 'ID пользователя должен быть числом.',
            'user_id.exists' => 'Выбранный пользователь не существует.',
            'type.required' => 'Выберите тип сообщения.',
            'type.string' => 'Тип сообщения должен быть строкой.',
            'type.in' => 'Неверный тип сообщения.',
            'message.string' => 'Сообщение должно быть строкой.',
            'message.required' => 'Сообщение обязательно для текстового типа.',
            'reply_message_id.integer' => 'ID ответа должен быть числом.',
            'reply_message_id.exists' => 'Ответ на несуществующее сообщение.',
            'media_file.file' => 'Медиафайл должен быть файлом.',
            'media_file.mimes' => 'Медиафайл должен иметь расширения: webm, mkv, mp3, mp4, jpg, png.',
            'media_file.max' => 'Максимальный размер медиафайла 10 МБ.',
        ];
    }
}
