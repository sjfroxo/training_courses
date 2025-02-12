<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserCourseDTO;
use App\Http\Requests\UserCourseRequest;
use App\Models\UserCourse;
use App\Services\UserCourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserCourseController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param UserCourseService $service
     * @param Request $request
     */
    public function __construct(
        protected UserCourseService $service,
        protected Request           $request,
    )
    {}

    /**
     * @param UserCourseRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * Ожидает от клиента course_id, user_id, progress
     */
    public function store(UserCourseRequest $request): RedirectResponse
    {
        $this->authorize('create', UserCourse::class);

        $this->service->create(UserCourseDTO::appRequest($request));

        return to_route('users.show', ['user' => $request['user_id']]);
    }

    /**
     * @param string $id
     *
     * @return RedirectResponse
     * Клиент должен послать именно id UserCourse
     * через pivot
     * Например:>$user->courses->find($course->id)->pivot->id
     * @throws AuthorizationException
     */
    public function destroy(string $id): RedirectResponse
    {
        $userCourse = $this->service->findById($id);

        $this->authorize('delete', $userCourse);

        $this->service->destroyById($id);

        return to_route('users.show', ['user' => $userCourse['user_id']]);
    }
}
