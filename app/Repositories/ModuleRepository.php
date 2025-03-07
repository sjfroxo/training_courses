<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Module;
use App\Repositories\Interfaces\ModuleRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModuleRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param Module $model
	 *
	 * @return void
	 */
	public function __construct(Module $model)
	{
		parent::__construct($model);
	}

    public function firstWithModule(string $id): Model|Builder
    {
        return $this->model->query()
            ->where('id', '=', $id)
            ->with('course')
            ->first();
    }

    public function findCourses(): Collection
    {
        return Course::all();
    }
}
