<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Models\StudentsClass;
use App\Models\User;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\StudentsClassRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StudentsClassRepository extends CoreRepository implements StudentsClassRepositoryInterface
{
    /**
     * @param StudentsClass $model
     */
    public function __construct(StudentsClass $model)
    {
        parent::__construct($model);
    }
}
