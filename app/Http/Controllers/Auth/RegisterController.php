<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\RegisterUserDTO;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
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
        protected Request $request,
    )
    {}

    /**
     * @param RegisterUserRequest $request
     *
     * @return RedirectResponse
     */
	public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = $this->service->create(RegisterUserDTO::appRequest($request));

		$this->service->authLogin($user);

        return to_route('courses');
    }
}
