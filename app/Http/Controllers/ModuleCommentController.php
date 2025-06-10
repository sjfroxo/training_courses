<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleCommentDTO;
use App\Http\Requests\ModuleCommentRequest;
use App\Models\ModuleComment;
use App\Services\ModuleCommentService;
use App\Services\ModuleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleCommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param ModuleCommentService $service
     * @param ModuleService $moduleService
     * @param Request $request
     */
    public function __construct(
        protected ModuleCommentService $service,
        protected ModuleService        $moduleService,
        protected Request              $request,
    )
    {
    }

    /**
     * @param ModuleCommentRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ModuleCommentRequest $request): RedirectResponse
    {
        $this->authorize('create', [ModuleComment::class, $request['module_id']]);

        $module = $this->moduleService->firstWithModule($request['module_id']);

        $validated = $request->validated();

        $dto = new ModuleCommentDTO(
            $validated['user_id'],
            $validated['module_id'],
            $validated['text'],
        );

        $this->service->create($dto);

        return to_route('modules.show', ['slug' => $module->slug]);
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

        return back();
    }

    /**
     * @param ModuleCommentRequest $request
     * @param string $id
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ModuleCommentRequest $request, string $id): RedirectResponse
    {
        $entity = $this->service->findById($id);

        $this->authorize('update', $entity);


        $validated = $request->validated();

        $dto = new ModuleCommentDTO(
            $validated['user_id'],
            $validated['module_id'],
            $validated['text'],
        );

        $this->service->update($entity, $dto);

        return back();
    }
}
