<?php

namespace App\Services;

use App\Contracts\ModelDTO;
use App\DataTransferObjects\StudentsClassDTO;
use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\StudentsClassRepository;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class StudentsClassService extends CoreService
{
    /**
     * @param StudentsClassRepository $repository
     */
    public function __construct(StudentsClassRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getStudentsClasses(): Collection
    {
        return $this->repository->getStudentsClasses();
    }

    public function create(StudentsClassDTO|ModelDTO $data): Model
    {
        $studentsClass = $this->repository->create($data->toArray());

        $studentsClass->users()->attach($data->curator_id, [
            'user_role_id' => UserRoleEnum::CURATOR->value,
        ]);

        foreach ($data->student_ids as $studentId) {
            $studentsClass->users()->attach($studentId, [
                'user_role_id' => UserRoleEnum::USER->value,
            ]);
        }

        return $studentsClass;
    }
}
