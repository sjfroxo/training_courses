<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginWithGoogleController extends Controller
{
    public function __construct(protected AuthService $service)
    {
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

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

            return redirect('/courses');
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Ошибка входа через Google: ' . $e->getMessage()]);
        }
    }
}
