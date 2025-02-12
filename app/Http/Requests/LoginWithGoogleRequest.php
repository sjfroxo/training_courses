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
            'email' => ['required','string','email','max:255'],
			'name' => ['required','string','max:255'],
			'surname' => ['required','string','max:255'],
			'google_id' => ['required', 'string'],
        ];
    }
}
