<?php

namespace App\Http\Controllers\Auth;

use App\Services\LoginWithGoogleService;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginWithGoogleController extends Controller
{
    public function __construct(protected LoginWithGoogleService $service)
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

            $this->service->LoginWithGoogle($provider, $socialUser);

            return redirect('/courses');
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Ошибка входа через Google: ' . $e->getMessage()]);
        }
    }
}
