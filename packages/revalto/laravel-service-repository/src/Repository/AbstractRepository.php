<?php

namespace Revalto\ServiceRepository\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Revalto\ServiceRepository\DataMapper\DefaultEntity;
use Revalto\ServiceRepository\Enums\RepositoryParamEnum;
use stdClass;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * @return string
     */
    public function entity(): string
    {
        return DefaultEntity::class;
    }

    /**
     * @param int $perPage
     * @param string[] $columns
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'],
                             string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        return $this->newQuery()->toBase()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->applyQueryParams(
            $this->model::query()
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    protected function applyQueryParams(Builder $query): Builder
    {
        foreach (RepositoryParamEnum::cases() as $param) {
            if (isset($this->params[$param->value])) {
                $query->{$param->value}($this->params[$param->value]);
            }
        }

        return $query;
    }

    /**
     * @param int $id
     * @return null|stdClass
     */
    public function firstById(int $id): ?stdClass
    {
        return $this->first($id);
    }

    /**
     * @param mixed $value
     * @param string $column
     *
     * @return stdClass|null
     */
    public function first(mixed $value, string $column = 'id'): ?Model
    {
        $qb = $this->newQuery()->toBase();

        return is_array($value)
            ? $qb->where($value)->first()
            : $qb->where($column, '=', $value)->first();
    }

    /**
     * @param array $fillable
     * @param string $orderField
     * @param string $orderType
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function where(array $fillable, string $orderField = 'id', string $orderType = 'desc'): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->newQuery()->where($fillable)
            ->orderBy($orderField, $orderType)
            ->get();
    }

    /**
     * @param array $fillable
     * @param string $orderField
     * @param string $orderType
     * @return Model
     */
    public function firstWhere(array $fillable, string $orderField = 'id', string $orderType = 'desc'): Model
    {
        return $this->newQuery()
            ->orderBy($orderField, $orderType)
            ->firstWhere($fillable);
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->newQuery()->toBase()->get();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return $this->exists($id);
    }

    /**
     * @param $value
     * @param string $column
     * @return bool
     */
    public function exists($value, string $column = 'id'): bool
    {
        $qb = $this->newQuery()->toBase();

        return is_array($value)
            ? $qb->where($value)->exists()
            : $qb->where($column, '=', $value)->exists();
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Builder|Model
     */
    public function firstOrCreate(array $attributes = [], array $values = []): Model|Builder
    {
        return $this->newQuery()->firstOrCreate($attributes, $values);
    }

    /**
     * @param int|array $id
     * @return bool
     */
    public function destroyById(int|array $id): bool
    {
        return $this->getModel()::destroy($id);
    }

    /**
     * @return Model
     */
    public function getModel(): string
    {
        return $this->model::class;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this|void
     */
    public function __call(string $name, array $arguments)
    {
        if (($method = RepositoryParamEnum::tryFrom($name)) !== null) {
            $this->setParam($method->value, ...$arguments);

            return $this;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function setParam(string $key, mixed $value): void
    {
        $this->params[$key] = $value;
    }

    /**
     * @param array $wheres
     * @return Builder
     */
    public function filter(array ...$wheres): Builder
    {
        $query = $this->model->newQuery();

        foreach ($wheres as $where) {
            if (empty($where[count($where) - 1])) {
                continue;
            }

            if (count($where) == 2) {
                $query->where($where[0], $where[1]);

                continue;
            }

            $query->where($where[0], $where[1], $where[2]);
        }

        return $query;
    }
}
