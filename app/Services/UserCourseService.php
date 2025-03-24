<?php

namespace App\Services;

use App\Repositories\UserCourseRepository;
use Error;

class UserCourseService extends CoreService
{
    /**
     * @param UserCourseRepository $repository
     */
    public function __construct(UserCourseRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return string
     */
    public function getProgress(): string
    {
        if (!auth()->user()) {
            throw new Error('Пользователь не авторизован!');
        }

        $totalCountCourses = $this->repository->getModuleExams();

        $countDoneUserCourses = $this->repository->getCurrentUserCourses();

        return number_format(($countDoneUserCourses * 100 / $totalCountCourses), 1);
    }
}
