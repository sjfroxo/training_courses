<?php

namespace App\Repositories;

use App\Models\ModuleSection;
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
    public function getModuleSections(): int
    {
        return ModuleSection::all()->count();
    }

    /**
     * @return int
     */
    public function getCurrentUserCourses(): int
    {
        $currentUserCourses = ModuleSection::query()->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });
        return $currentUserCourses->count();
    }

    public function getAverageUserScore(): string
    {
        $marks = ExamUserResult::query()->where('user_id', Auth::id())->pluck('mark');
        $sum = 0;
        foreach ($marks as $mark) {
            $sum += $mark;
        }

        return $marks->count() > 0 ? number_format($sum / $marks->count()) : 0;
    }
}
