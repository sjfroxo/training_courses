<?php

namespace App\Repositories;

use App\Models\ModuleExam;
use App\Repositories\Interfaces\ModuleExamRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModuleExamRepository extends CoreRepository implements ModuleExamRepositoryInterface
{
	/**
	 * @param ModuleExam $model
	 *
	 * @return void
	 */
	public function __construct(ModuleExam $model)
	{
		parent::__construct($model);
	}

    /**
     * @param string|int $id
     * @return Model|Builder
     */
    public function firstWithModule(string|int $id): Model|Builder
    {
        return $this->model->query()
            ->where('id', '=', $id)
            ->with('module')
            ->first();
    }
}
