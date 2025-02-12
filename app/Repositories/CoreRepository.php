<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CoreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepository as Repository;

abstract class CoreRepository extends Repository implements CoreRepositoryInterface
{
	/**
	 * @param Model $modelClass
	 */
	public function __construct(
		Model $modelClass
	)
	{
		parent::__construct($modelClass);
	}

	/**
	 * @return Collection
	 */
	public function all(): Collection
	{
		return $this->model->all();
	}

    /**
     * @param string|int $id
     * @return Model|Collection|Builder|null
     */
    public function findById(string|int $id): Model|Collection|Builder|null
    {
		return $this->getBuilder()->findOrFail($id);
	}

	/**
	 * @param Model $entity
	 *
	 * @return Model
	 */
	public function save(Model $entity): Model
	{
		return tap($entity)->save();
	}

	/**
	 * @param array<string,mixed> $data
	 *
	 * @return Model
	 */
	public function create(array $data): Model
	{
		return $this->getBuilder()->create($data);
	}

	/**
	 * @param Model $entity
	 * @param array<string, mixed> $data
	 *
	 * @return Model
	 */
	public function update(Model $entity, array $data): Model
	{
		return tap($entity)->update($data);
	}

	/**
	 * @param Model $entity
	 *
	 * @return Model
	 */
	public function destroy(Model $entity): Model
	{
		return tap($entity)->delete();
	}

	/**
	 * @return Builder<Model>
	 */
	public function getBuilder(): Builder
	{
		return $this->model->query();
	}

	/**
	 * @param string $slug
	 *
	 * @return Model
	 */
	public function findBySlug(string $slug): Model
	{
		return $this->getBuilder()->firstWhere('slug', $slug);
	}

	/**
	 * @param int $perPage
	 * @param array $columns
	 * @param string $pageName
	 * @param int|null $page
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate(
        int $perPage = 15,
        array $columns = ['*'],
        string $pageName = 'page',
        ?int $page = null): LengthAwarePaginator
	{
		return $this->getBuilder()->paginate($perPage, $columns, $pageName, $page);
	}
}
