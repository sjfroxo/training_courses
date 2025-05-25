<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService extends CoreService
{
	/**
	 * @param UserRepository $repository
	 */
	public function __construct(UserRepository $repository)
	{
		parent::__construct($repository);
	}

    public function getUsers(): Collection
    {
        return $this->repository->getUsers();
    }

	/**
	 * @param string $id
	 *
	 * @return Model
	 */
	public function getUserProfile(string $id): Model
	{
		$user = $this->repository->findById($id);
		$user->user_role = $this->repository->getUserRole($user);

		return $user;
	}

    /**
     * @param int $studentClassId
     * @return Model|null
     */
    public function getCuratorByStudentClassId(int $studentClassId): Model|null
    {
        return $this->repository->getCuratorByStudentClassId($studentClassId);
    }

    /**
     * @param int $courseId
     * @param array $filters
     * @return Collection
     */
    public function getCourseInterns(int $courseId, array $filters = []): Collection
    {
        return $this->repository->getCourseUsers($courseId, UserRoleEnum::USER, $filters);
    }
}
