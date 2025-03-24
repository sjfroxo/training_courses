<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Models\StudentsClass;
use App\Models\User;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StudentsClassRepository extends CoreRepository implements CourseRepositoryInterface
{
    /**
     * @param StudentsClass $model
     */
    public function __construct(StudentsClass $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function getStudentsClasses(): Collection
    {
        return StudentsClass::all();
    }

    /**
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return Course::all();
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::all();
    }

    public function getCurator(int $studentsClassId): ?Model
    {
        return User::query()
            ->whereHas('studentsClasses', function ($query) use ($studentsClassId) {
                $query->where('students_classes_users.students_class_id', $studentsClassId)
                    ->where('students_classes_users.user_role_id', UserRoleEnum::CURATOR->value);
            })
            ->first();
    }
}
