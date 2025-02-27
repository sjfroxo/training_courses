<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\StudentsClass;
use App\Models\User;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function getUsers(): Collection
    {
        return User::all();
    }
}
