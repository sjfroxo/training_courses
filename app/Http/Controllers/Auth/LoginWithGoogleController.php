<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\LoginWithGoogleDTO;
use App\Http\Requests\LoginWithGoogleRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginWithGoogleController extends Controller
{
    /**
     * @param AuthService $service
     */
    public function __construct(protected AuthService $service)
    {}

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function __invoke(): RedirectResponse
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Throwable $th) {
            return redirect()
                ->route('login')
                ->with('error', 'Не удалось перенаправить на страницу авторизации Google: ' . $th->getMessage());
        }
    }

    /**
     * Handle the Google callback and log the user in.
     *
     * @param LoginWithGoogleRequest $request
     * @return RedirectResponse
     */
    public function store(LoginWithGoogleRequest $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $nameParts = explode(' ', $googleUser->getName(), 2);
            $name = $nameParts[0] ?? $googleUser->getName();
            $surname = $nameParts[1] ?? '';

            $dto = new LoginWithGoogleDTO(
                email: $googleUser->getEmail(),
                name: $name,
                surname: $surname,
                google_id: $googleUser->getId(),
            );

            $user = $this->service->firstOrCreate($dto);

            $this->service->authLogin($user);

            return redirect()
                ->route('courses');
        } catch (Throwable $th) {
            return redirect()
                ->route('login')
                ->with('error', 'Ошибка авторизации через Google: ' . $th->getMessage());
        }
    }
}
