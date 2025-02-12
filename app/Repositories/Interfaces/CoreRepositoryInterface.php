<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface CoreRepositoryInterface extends AbstractRepositoryInterface
{
	/**
	 * @return Collection
	 */
	public function all(): Collection;

    /**
     * @return Builder
     */
    public function getBuilder(): Builder;

    /**
	 * @param string|int $id
	 *
	 * @return Model|Collection|Builder|null
	 */
	public function findById(string|int $id): Model|Collection|Builder|null;

    /**
     * @param string $slug
     *
     * @return Model|Collection|Builder|null
     */
    public function findBySlug(string $slug): Model|Collection|Builder|null;

    /**
	 * @param Model $entity
	 *
	 * @return Model
	 */
	public function save(Model $entity): Model;

    /**
	 * @param array $data
	 *
	 * @return Model
	 */
	public function create(array $data): Model;

    /**
	 * @param Model $entity
	 * @param array $data
	 *
	 * @return Model
	 */
	public function update(Model $entity, array $data): Model;

    /**
	 * @param Model $entity
	 *
	 * @return Model
	 */
	public function destroy(Model $entity): Model;

	/**
	 * @param int $perPage
	 * @param array $columns
	 * @param string $pageName
	 * @param int|null $page
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator;
}
