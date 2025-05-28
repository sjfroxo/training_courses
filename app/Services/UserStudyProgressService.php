<?php

namespace App\Services;

use App\Repositories\UserCourseRepository;
use Error;

class UserStudyProgressService extends CoreService
{
    /**
     * @param UserCourseRepository $repository
     */
    public function __construct(UserCourseRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getProgress(): string
    {
        if (!auth()->user()) {
            throw new Error('Пользователь не авторизован!');
        }

        $totalCountCourses = $this->repository->getModuleExams();

        $countDoneUserCourses = $this->repository->getCurrentUserCourses();

        if ($totalCountCourses == 0) {
            return '0';
        }

        return number_format(($countDoneUserCourses * 100 / $totalCountCourses));
    }

    public function getAverageUserScore()
    {
        return $this->repository->getAverageUserScore();
    }
}
