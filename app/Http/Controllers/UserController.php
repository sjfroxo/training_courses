<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDTO;
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
	 * @param string $id
	 *
	 * @return View
	 */
	public function show(string $id): View
	{
		$user = $this->service->getUserProfile($id);

		return view('account', ['user' => $user]);
	}

	/**
	 * @param string $id
	 *
	 * @return View
	 */
	public function edit(string $id): View
	{
		$user = $this->service->findById($id);

		return view('account-edit', ['user' => $user]);
	}

	/**
	 * @param UserRequest $request
	 * @param string $id
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UserRequest $request, string $id): RedirectResponse
	{
        $user = $this->service->findById($id);

        $this->authorize('update', $user);

        $entity = $this->service->findById($id);

        $this->service->update(
            $entity,
            UserDTO::appRequest($request)
        );

		return to_route('account.show', ['id' => $id]);
	}
}
