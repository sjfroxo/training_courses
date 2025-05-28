<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\LoginUserDTO;
use App\Enums\UserRoleEnum;
use App\Http\Requests\LoginUserRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __construct(
        protected AuthService $service,
        protected Request $request,
    ) {}

    public function authenticate(LoginUserRequest $request): RedirectResponse
    {
        Log::info('CSRF Token from session: ' . $request->session()->token());
        Log::info('CSRF Token from request: ' . $request->input('_token'));

        $validated = $request->validated();

        $dto = new LoginUserDTO(
            $validated['email'],
            $validated['password'],
        );

        $credentials = $dto->toArray();
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $this->service->regenerateSession($request);

            switch (UserRoleEnum::tryFrom(auth()->user()->user_role_id)) {
                case UserRoleEnum::USER:
                    return to_route('courses');
                case UserRoleEnum::UNVERIFIED:
                    return redirect()->back();
                case UserRoleEnum::CURATOR:
                    return to_route('curator.course.index');
                case UserRoleEnum::ADMIN:
                    return to_route('chats.index');
                case UserRoleEnum::DECLINED:
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'email' => 'Ваш аккаунт отклонён.',
                    ]);
            }
            return to_route('courses');
        }

        return back()->withErrors([
            'email' => 'Введены неверные данные.',
        ])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
