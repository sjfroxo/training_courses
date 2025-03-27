<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserCourseDTO;
use App\Http\Requests\UserCourseRequest;
use App\Models\User;
use App\Models\UserCourse;
use App\Services\UserCourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class UserCourseController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected UserCourseService $service)
    {
    }

    /**
     * @param UserCourseRequest $request
     * @return RedirectResponse
     */
    public function store(UserCourseRequest $request): RedirectResponse
    {
        $this->authorize('create', UserCourse::class);

        $this->service->create(UserCourseDTO::appRequest($request));

        return to_route('users.show', ['user' => $request['user_id']]);
    }

    /**
     * @param string $user
     * @param string $userCourse
     * @return RedirectResponse
     * Клиент должен послать именно id UserCourse через pivot
     * Например:>$user->courses->find($course->id)->pivot->id
     * @throws AuthorizationException
     */
    public function destroy(string $user, string $userCourse): RedirectResponse
    {
        $userModel = User::query()->findOrFail($user);
        $userCourseModel = $this->service->findById($userCourse);

        $this->authorize('delete', $userCourseModel);

        $this->service->destroyById($userCourse);

        return to_route('users.show', ['user' => $userModel->id]);
    }
}
