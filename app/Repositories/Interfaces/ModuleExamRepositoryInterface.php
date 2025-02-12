<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ModuleExamRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string|int $id
     * @return Model|Builder|null
     */
    public function firstWithModule(string|int $id): Model|Builder|null;
}
