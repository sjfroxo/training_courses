<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param User $model
	 */
	public function __construct(User $model)
	{
		parent::__construct($model);
	}

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::all();
    }

	/**
	 * @param User $user
	 *
	 * @return string
	 */
	public function getUserRole(User $user): string
	{
		return $user->role()->first()->title;
	}

    /**
     * @param int $studentsClassId
     * @return Model|null
     */
    public function getCuratorByStudentClassId(int $studentsClassId): ?Model
    {
        return $this->model::query()
            ->whereHas('studentsClasses', function ($query) use ($studentsClassId) {
                $query->where('students_classes_users.students_class_id', $studentsClassId)
                    ->where('students_classes_users.user_role_id', UserRoleEnum::CURATOR->value);
            })
            ->first();
    }

    /**
     * @param int $courseId
     * @param UserRoleEnum|null $userRoleEnum
     * @param array $filters
     * @return Collection
     */
    public function getCourseUsers(int $courseId, UserRoleEnum $userRoleEnum = null, array $filters = []): Collection
    {
        $query = $this->filter($filters);

        return $query
            ->whereHas('courses', fn ($query) => $query->where('courses.id', '=', $courseId))
            ->when($userRoleEnum, fn ($query) => $query->where('user_role_id', '=', $userRoleEnum->value))
            ->get();
    }
}
