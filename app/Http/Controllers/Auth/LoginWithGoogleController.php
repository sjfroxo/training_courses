<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\LoginWithGoogleDTO;
use App\Http\Requests\LoginWithGoogleRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class LoginWithGoogleController extends Controller
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
     * @param LoginWithGoogleRequest $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
	public function store(LoginWithGoogleRequest $request):RedirectResponse
	{
		try {
//			$request = $this->getGoogleRequest($request);

			$user = $this->service->firstOrCreate(LoginWithGoogleDTO::appRequest($request));

			$this->service->authLogin($user);

			return to_route('courses');
		}
		catch(\Throwable $th){
			throw new Exception("Error: ".$th->getMessage(),$th->getCode());
		}
	}

	/**
	 * @return RedirectResponse
	 */
	public function __invoke():RedirectResponse
	{
		return Socialite::driver('google')->redirect();
	}

	/**
	 * @param Request $request
	 *
	 * @return Request
	 */
	public function getGoogleRequest(Request $request):Request
	{
		$googleUser = Socialite::driver('google')->user();

		$request->merge([
				'email' => $googleUser->getEmail(),
				'name' => $googleUser->getName(),
				'surname' => $googleUser->getName(),
				'google_id' => $googleUser->getId()
			]);

		return $request;
	}
}
