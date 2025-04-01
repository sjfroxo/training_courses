<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AdminUserDTO;
use App\Http\Requests\AdminUserRequest;
use App\Models\User;
use App\Services\CourseService;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class AdminUserController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param UserService $service
     * @param UserRoleService $userRoleService
     * @param CourseService $courseService
     */
    public function __construct(
        protected UserService      $service,
        protected UserRoleService  $userRoleService,
        protected CourseService    $courseService,
    )
    {
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = $this->service->paginate(10);

        return view('users', ['users' => $users]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $roles = $this->userRoleService->all();

        $this->authorize('create', User::class);

        return view('create-user', ['roles' => $roles]);
    }

    /**
     * @param AdminUserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(AdminUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $dto = new AdminUserDTO(
            $validated['user_role_id'],
            $validated['name'],
            $validated['surname'],
            $validated['email'],
            $validated['password'],
        );

        $this->service->create($dto);

        return to_route('users');
    }

    /**
     * @param string $id
     *
     * @return View
     * @throws AuthorizationException
     */
    public function edit(string $id): View
    {
        $user = $this->service->findById($id);

        $roles = $this->userRoleService->all();

        $this->authorize('update', $user);

        return view('edit-user', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * @param AdminUserRequest $request
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function update(AdminUserRequest $request, string $id): RedirectResponse
    {
        $user = $this->service->findById($id);

        $this->authorize('update', $user);

        $entity = $this->service->findById($id);

        $validated = $request->validated();

        $dto = new AdminUserDTO(
            $validated['user_role_id'],
            $validated['name'],
            $validated['surname'],
            $validated['email'],
            $validated['password'],
        );

        $this->service->update($entity, $dto);

        return to_route('users');
    }

    /**
     * @param string $id
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(string $id): RedirectResponse
    {
        $model = $this->service->findById($id);

        $this->authorize('delete', $model);

        $this->service->destroyById($id);

        return to_route('users');
    }

    /**
     * @param string $id
     *
     * @return View
     * @throws AuthorizationException
     */
    public function show(string $id): View
    {
        $user = $this->service->findById($id);

        $courses = $this->courseService->all();

        $this->authorize('view', $user);

        return view('show-user', [
            'user' => $user,
            'courses' => $courses
        ]);
    }
}
