<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatMessageRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string>
	 */
	public function rules(): array
	{
		return [
			'message' => ['string', 'nullable'],
			'user_id' => ['required', 'string', 'exists:users,id'],
			'chat_id' => ['required', 'string', 'exists:chats,id'],
			'type' => ['required', 'string', 'in:text,voice,video'],
			'reply_message_id' => ['nullable', 'string', 'exists:chat_messages,id'],
			'media_file' => ['nullable', 'file', 'mimes:webm,mkv', 'max:10240'],
		];
	}

	/**
	 * @return string[]
	 */
	public function messages(): array
	{
		return [
			'message.string' => 'Сообщение должно быть строкой.',
			'user_id.required' => 'Пользователь обязателен для заполнения.',
            'user_id.string' => 'Пользователь должен быть строкой.',
			'user_id.exists' => 'Выбранный пользователь не существует.',
			'chat_id.required' => 'Чат обязателен для заполнения.',
            'chat_id.string' => 'Чат должен быть строкой.',
			'chat_id.exists' => 'Выбранный чат не существует.',
			'type.required' => 'Выберите тип',
            'type.string' => 'Тип должен быть строкой.',
			'type.in' => 'Неверный тип сообщения.',
            'reply_message_id.string' => 'Ответ должен быть строкой.',
			'reply_message_id.exists' => 'Ответ на несуществующее сообщение.',
			'media_file.file' => 'Медиафайл должен быть файлом.',
			'media_file.mimes' => 'Медиафайл должен иметь расширения webm,mkv.',
			'media_file.max' => 'Максимальный размер медиафайла 10240.',
		];
	}
}
