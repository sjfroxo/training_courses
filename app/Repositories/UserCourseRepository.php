<?php

namespace App\Repositories;

use App\Models\ExamUserResult;
use App\Models\ModuleExam;
use App\Models\UserCourse;
use App\Repositories\Interfaces\UserCourseRepositoryInterface as RepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserCourseRepository extends CoreRepository implements RepositoryInterface
{
    /**
     * @param UserCourse $model
     *
     * @return void
     */
    public function __construct(UserCourse $model)
    {
        parent::__construct($model);
    }

    /**
     * @return int
     */
    public function getCurrentUserCourses(): int
    {
        $currentUserCourses = ModuleExam::query()->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });
        return $currentUserCourses->count();
    }

    /**
     * @return int
     */
    public function getModuleExams(): int
    {
        return ModuleExam::all()->count();
    }

    public function getAverageUserScore()
    {
        $marks = ExamUserResult::query()->where('user_id', Auth::id())->pluck('mark');
        $sum = 0;
        foreach ($marks as $mark) {
            $sum += $mark;
        }

        return number_format($sum / $marks->count());
    }
}
