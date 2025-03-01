<?php

namespace App\Services;

use App\Contracts\ModelDTO;
use App\Repositories\CoreRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Revalto\ServiceRepository\Service\AbstractService as Service;

abstract class CoreService extends Service
{
	/**
	 * @param CoreRepository $repository
	 */
	public function __construct(
		CoreRepository $repository,
	)
	{
		parent::__construct($repository);
	}

    /**
     * @param ModelDTO $data
     * @return Model
     */
	public function create(ModelDTO $data): Model
	{
		$dto = $data->toArray();

		return $this->repository->create($dto);
	}

    /**
     * @param Model $id
     * @param ModelDTO $data
     * @return Model
     */
	public function update(Model $id, ModelDTO $data): Model
	{
		$dto = $data->toArray();

		return $this->repository->update(
			$id,
			$dto
		);
	}

	/**
	 * @param Request $request
	 *
	 * @return Model
	 */
	public function destroy(Request $request): Model
	{
		$entity = $this->findById($request['id']);

		$this->repository->destroy($entity);

		return $entity;
	}

    public function destroyById(string $id): Model
    {
        $entity = $this->findById($id);

        $this->repository->destroy($entity);

        return $entity;
    }

	/**
	 * @param string $id
	 *
	 * @return Model
	 */
	public function findById(string $id): Model
	{
		return $this->repository->findById($id);
	}

	public function findBySlug(string $slug): Model
	{
		return $this->repository->findBySlug($slug);
	}

	public function all()
	{
		return $this->repository->all();
	}

	/**
	 * @param int $perPage
	 * @param array $columns
	 * @param string $pageName
	 * @param int|null $page
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
	{
		return $this->repository->paginate($perPage, $columns, $pageName, $page);
	}
}
