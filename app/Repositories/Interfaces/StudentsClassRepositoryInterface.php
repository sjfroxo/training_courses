<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface StudentsClassRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getStudentsClasses(): Collection;

    /**
     * @return Collection
     */
    public function getCourses(): Collection;

    /**
     * @return Collection
     */
    public function getUsers(): Collection;

    /**
     * @param int $studentsClassId
     * @return Model|null
     */
    public function getCurator(int $studentsClassId): ?Model;
}
