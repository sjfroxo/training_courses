<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CuratorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'curator_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'curator_id.required' => 'Необходимо выбрать куратора.',
            'curator_id.integer' => 'Айди куратора должно быть числом.',
            'curator_id.exists' => 'Выбранный куратор не существует.',
        ];
    }
}
