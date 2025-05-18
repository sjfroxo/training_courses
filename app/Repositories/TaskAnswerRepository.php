<?php

namespace App\Repositories;

use App\Models\TaskAnswer;
use App\Repositories\Interfaces\TaskAnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskAnswerRepository extends CoreRepository implements TaskAnswerRepositoryInterface
{
    /**
     * @param TaskAnswer $model
     */
	public function __construct(TaskAnswer $model)
	{
		parent::__construct($model);
	}

    public function getForCurator(): Collection
    {
        return $this->model->query()
            ->with([
                'task',
                'user' => fn ($query) => $query->select('users.id', 'users.name', 'users.surname')
            ])
            ->get();
    }
}
