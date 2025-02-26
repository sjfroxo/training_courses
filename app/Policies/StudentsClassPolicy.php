<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\StudentsClass;
use App\Models\User;

class StudentsClassPolicy
{
    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool|null
     */
    public function before(User $user, string $ability): bool|null
    {
        if($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param StudentsClass $studentsClass
     *
     * @return bool
     */
    public function view(User $user, StudentsClass $studentsClass): bool
    {
        return $user->studentsClass->contains('id', $studentsClass->id);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * @param User $user
     * @param StudentsClass $studentsClass
     *
     * @return bool
     */
    public function update(User $user, StudentsClass $studentsClass): bool
    {
        return $user->isAdministrator();
    }

    /**
     * @param User $user
     * @param StudentsClass $studentsClass
     *
     * @return bool
     */
    public function delete(User $user, StudentsClass $studentsClass): bool
    {
        return $user->isAdministrator();
    }

    /**
     * @param User $user
     * @param StudentsClass $studentsClass
     *
     * @return bool
     */
    public function restore(User $user, StudentsClass $studentsClass): bool
    {
        return $user->isAdministrator();
    }

    /**
     * @param User $user
     * @param StudentsClass $studentsClass
     *
     * @return bool
     */
    public function forceDelete(User $user, StudentsClass $studentsClass): bool
    {
        return $user->isAdministrator();
    }
}
