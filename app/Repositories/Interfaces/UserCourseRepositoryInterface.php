<?php

namespace App\Repositories\Interfaces;

use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface UserCourseRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return int
     */
    public function getCurrentUserCourses(): int;

    /**
     * @return int
     */
    public function getModuleExams(): int;
}
