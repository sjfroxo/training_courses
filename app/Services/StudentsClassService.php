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
     */
    public function __construct(
        StudentsClassRepository $repository
    )
    {
        parent::__construct($repository);
    }

    /**
     * @return Collection
     */
    public function getStudentsClasses(): Collection
    {
        return $this->repository->getStudentsClasses();
    }

    /**
     * @param StudentsClassDTO|ModelDTO $dto
     * @return Model
     */
    public function create(StudentsClassDTO|ModelDTO $dto): Model
    {
        $studentsClass = $this->repository->create([
            'name' => $dto->name,
            'course_id' => $dto->course_id,
        ]);

        $studentsClass->users()->attach($dto->curator_id, [
            'user_role_id' => UserRoleEnum::CURATOR->value,
        ]);

        foreach ($dto->student_ids as $studentId) {
            $studentsClass->users()->attach($studentId, [
                'user_role_id' => UserRoleEnum::USER->value,
            ]);
        }

        return $studentsClass;
    }

    /**
     * @param StudentsClass|Model $entity
     * @param StudentsClassDTO|ModelDTO $data
     * @return Model
     */
    public function update(StudentsClass|Model $entity, StudentsClassDTO|ModelDTO $data): Model
    {
        $dto = $data->toArray();

        $entity->update([
            'name' => $dto['name'],
            'course_id' => $dto['course_id'],
        ]);

        $syncData = [];
        $syncData[$dto['curator_id']] = ['user_role_id' => UserRoleEnum::CURATOR->value];

        foreach ($dto['student_ids'] as $studentId) {
            $syncData[$studentId] = ['user_role_id' => UserRoleEnum::USER->value];
        }

        $entity->users()->sync($syncData);

        return $entity;
    }

    /**
     * @return mixed
     */
    public function getCourses(): mixed
    {
        return $this->repository->getCourses();
    }

    /**
     * @return mixed
     */
    public function getUsers(): mixed
    {
        return $this->repository->getUsers();
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
        $user = User::query()->find($curatorId);
        if (!$user || $user->user_role_id !== UserRoleEnum::CURATOR->value) {
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
     * @return mixed
     */
    public function getCuratorForClass(int $studentsClassId)
    {
        return $this->repository->getCurator($studentsClassId);
    }
}
