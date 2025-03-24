<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ModuleRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $id
     * @return Model|Builder
     */
    public function firstWithModule(string $id): Model|Builder;

    /**
     * @return Collection
     */
    public function findCourses(): Collection;
}
