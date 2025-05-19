<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\LoginUserDTO;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param AuthService $service
     * @param Request $request
     */
    public function __construct(
        protected AuthService $service,
        protected Request     $request,
    )
    {}

    /**
     * @param LoginUserRequest $request
     *
     * @return RedirectResponse
     */
    public function authenticate(LoginUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new LoginUserDTO(
            $validated['email'],
            $validated['password'],
        );

        $credentials = $dto->toArray();
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $this->service->regenerateSession($request);

            return to_route('courses');
        }

        return back()->withErrors([
            'email' => 'Введены неверные данные.',
        ])->withInput();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
