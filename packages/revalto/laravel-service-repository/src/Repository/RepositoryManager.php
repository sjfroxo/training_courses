<?php

namespace Revalto\ServiceRepository\Repository;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Revalto\ServiceRepository\DataMapper\DataMapper;

class RepositoryManager
{
    /**
     * @param AbstractRepositoryInterface $repository
     */
    public function __construct(
        protected AbstractRepositoryInterface $repository,
    ) {}

    /**
     * @param mixed $data
     * @return mixed
     */
    public function transform(Collection|EloquentCollection|LengthAwarePaginator|Model|array|\stdClass $data): mixed
    {
        return (new DataMapper($data, $this->repository->entity()))
            ->transform();
    }

    /**
     * @param $response
     * @return bool
     */
    protected function isToTransform($response): bool
    {
        return $response instanceof Model
            || $response instanceof Collection
            || $response instanceof EloquentCollection
            || $response instanceof LengthAwarePaginator
            || $response instanceof \stdClass
            || is_array($response);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        $response = $this->repository->{$name}(...$arguments);

        if ($this->isToTransform($response)) {
            return $this->transform($response);
        }

        return $response;
    }
}
