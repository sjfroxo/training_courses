<?php

namespace App\Services;

use App\Contracts\ModelDTO;
use App\DataTransferObjects\StudentsClassDTO;
use App\Models\StudentsClass;
use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\StudentsClassRepository;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Ramsey\Collection\Collection;

class StudentsClassService extends CoreService
{
    /**
     * @param StudentsClassRepository $repository
     * @param UserService $userService
     */
    public function __construct(
        StudentsClassRepository $repository,
        protected UserService $userService
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param StudentsClassDTO|ModelDTO $data
     * @return Model
     */
    public function create(StudentsClassDTO|ModelDTO $data): Model
    {
        $studentsClass = $this->repository->create([
            'name' => $data->name,
            'course_id' => $data->course_id,
        ]);

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

    /**
     * @param StudentsClass|Model $id
     * @param StudentsClassDTO|ModelDTO $data
     * @return Model
     */
    public function update(StudentsClass|Model $id, StudentsClassDTO|ModelDTO $data): Model
    {
        $dto = $data->toArray();

        $id->update([
            'name' => $dto['name'],
            'course_id' => $dto['course_id'],
        ]);

        $syncData = [];
        $syncData[$dto['curator_id']] = ['user_role_id' => UserRoleEnum::CURATOR->value];

        foreach ($dto['student_ids'] as $studentId) {
            $syncData[$studentId] = ['user_role_id' => UserRoleEnum::USER->value];
        }

        $id->users()->sync($syncData);

        return $id;
    }

    /**
     * @param StudentsClass $studentsClass
     * @param array $studentIds
     * @return array
     */
    public function addStudents(StudentsClass $studentsClass, array $studentIds): array
    {
        $attachData = [];
        foreach ($studentIds as $studentId) {
            $attachData[$studentId] = ['user_role_id' => UserRoleEnum::USER->value];
        }

        return $studentsClass->users()->syncWithoutDetaching($attachData);
    }

    /**
     * @param StudentsClass $studentsClass
     * @param int $curatorId
     * @return void
     */
    public function addCurator(StudentsClass $studentsClass, int $curatorId): void
    {
        $user = $this->userService->findById($curatorId);
        if ($user->user_role_id !== UserRoleEnum::CURATOR->value) {
            throw new InvalidArgumentException('Указанный пользователь не является куратором.');
        }

        $currentCurator = $studentsClass->users()->wherePivot('user_role_id', UserRoleEnum::CURATOR->value)->first();
        if ($currentCurator) {
            $studentsClass->users()->detach($currentCurator->id);
        }

        $studentsClass->users()->attach($curatorId, [
            'user_role_id' => UserRoleEnum::CURATOR->value,
        ]);
    }

    /**
     * @param StudentsClass $studentsClass
     * @param int $studentId
     * @return int
     */
    public function removeStudent(StudentsClass $studentsClass, int $studentId): int
    {
        return $studentsClass->users()->detach($studentId);
    }

    /**
     * @param int $studentsClassId
     * @return Model|null
     */
    public function getCuratorForClass(int $studentsClassId): Model|null
    {
        return $this->userService->getCuratorByStudentClassId($studentsClassId);
    }
}
