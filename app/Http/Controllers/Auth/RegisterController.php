<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\RegisterUserDTO;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    /**
     * @param AuthService $service
     * @param Request $request
     */
    public function __construct(
        protected AuthService $service,
        protected Request     $request,
    )
    {
    }

    /**
     * @param RegisterUserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new RegisterUserDTO(
            $validated['name'],
            $validated['surname'],
            $validated['email'],
            $validated['password'],
        );

        $user = $this->service->create($dto);

        $this->service->authLogin($user);

        event(new Registered($user));

        return to_route('verification.notice');
    }

    public function verifyNotice()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->route('courses');
    }

    public function verifyHandler(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
