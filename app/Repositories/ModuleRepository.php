<?php

namespace App\Repositories;

use App\Models\Module;
use App\Repositories\Interfaces\ModuleRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
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

//    public function firstWithModule(string|int $id): Model|Builder|null
//    {
//        dd( $this->model->query()
//            ->where('id', '=', $id)
//            ->with('course')
//            ->first());
//    }
}
