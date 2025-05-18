<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDTO;
use App\Enums\UserRoleEnum;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param UserService $service
     */
	public function __construct(
        protected UserService $service,
    )
	{}

	/**
	 * @return View
	 */
	public function show(): View
	{
        $user = auth()->user();
        $user->user_role = UserRoleEnum::tryFrom($user->user_role_id)->titleEn();

		return view('account', ['user' => $user]);
	}

	/**
	 * @return View
	 */
	public function edit(): View
	{
		return view('account-edit', ['user' => auth()->user()]);
	}

	/**
	 * @param UserRequest $request
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UserRequest $request): RedirectResponse
	{
        $user = auth()->user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('profile_avatars');
        }

        $dto = new UserDTO(
            data_get($data, 'name'),
            data_get($data, 'surname'),
            $path ?? null
        );

        $this->service->update($user, $dto);

		return to_route('account.show', ['id' => $user->id]);
	}
}
