<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use Illuminate\Support\Collection;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface CourseRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $courseId
     * @return Course
     */
    public function getUsers(int $courseId): Course;
}
