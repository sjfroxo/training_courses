<?php

namespace Revalto\ServiceRepository\DataMapper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class DataMapper
{
    /**
     * @param Collection|EloquentCollection|LengthAwarePaginator|Model|array|\stdClass $data
     * @param string $entity
     */
    public function __construct(
        protected Collection|EloquentCollection|LengthAwarePaginator|Model|array|\stdClass $data = [],
        protected string $entity = DefaultEntity::class,
    ) {}

    /**
     * @param Collection|EloquentCollection|LengthAwarePaginator|array $data
     * @return Collection
     */
    public function toCollection(Collection|EloquentCollection|LengthAwarePaginator|array $data): Collection
    {
        return $this->prepareForCollection($data ?? $this->data)->map(function ($item) {
            try {
                return $this->toEntity($item);
            } catch (\Throwable) {
                return $item;
            }
        });
    }

    /**
     * @param Model|\stdClass $data
     * @return mixed
     */
    public function toEntity(Model|\stdClass $data): mixed
    {
        return new $this->entity(
            $data instanceof Model ? $data->toArray() : (array) $data
        );
    }

    /**
     * @return bool
     */
    protected function isCollection(): bool
    {
        return $this->data instanceof Collection
            || $this->data instanceof EloquentCollection
            || $this->data instanceof LengthAwarePaginator
            || (is_array($this->data) && array_is_list($this->data));
    }

    /**
     * @param Collection|EloquentCollection|LengthAwarePaginator|array $data
     * @return Collection
     */
    protected function prepareForCollection(Collection|EloquentCollection|LengthAwarePaginator|array $data): Collection
    {
        if($data instanceof EloquentCollection || $data instanceof LengthAwarePaginator) {
            return $data->toBase();
        } elseif(is_array($data)) {
            return collect($data);
        }

        return $data;
    }

    /**
     * @return Collection|mixed
     */
    public function transform(): mixed
    {
        return $this->isCollection()
            ? $this->toCollection($this->data)
            : $this->toEntity($this->data);
    }
}
