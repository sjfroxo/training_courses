<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\StudentsClass;
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

    public function getStudentsClasses(): Collection
    {
        return StudentsClass::all();
    }
}
