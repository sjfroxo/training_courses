<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleCommentDTO;
use App\Http\Requests\ModuleCommentRequest;
use App\Models\ModuleComment;
use App\Services\ModuleCommentService;
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
     * @param Request $request
     */
	public function __construct(
		protected ModuleCommentService $service,
        protected Request         $request,
    )
    {}

	/**
	 * @param ModuleCommentRequest $request
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(ModuleCommentRequest $request): RedirectResponse
	{
		$this->authorize('create', [ModuleComment::class, $request['module_id']]);

		$module = $this->service->findById($request['module_id']);

        $this->service->create(ModuleCommentDTO::appRequest($request));

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
        $moduleComment = $this->service->findById($id);

        $this->authorize('update', $moduleComment);

        $entity = $this->service->findById($id);

        $this->service->update(
            $entity,
            ModuleCommentDTO::appRequest($request)
        );

		return back();
	}
}
