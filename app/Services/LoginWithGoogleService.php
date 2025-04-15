<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LoginWithGoogleService
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Выполняет регистрацию пользователя.
     *
     * @param string $provider
     * @param $socialUser
     * @return Model
     */
    public function LoginWithGoogle(string $provider, $socialUser): Model
    {
        $nameParts = explode(' ', $socialUser->getName());
        $firstName = $nameParts[0] ?? '';
        $surname = $nameParts[1] ?? '';

        $user = User::query()->updateOrCreate([
            'email' => $socialUser->getEmail()
        ],
            [
                'name' => $firstName,
                'surname' => $surname,
                'email_verified_at' => now(),
                'google_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()),
            ]
        );

        Auth::login($user);

        event(new Registered($user));

        return $user;
    }
}
