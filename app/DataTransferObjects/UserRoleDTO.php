<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRoleRequest;

class UserRoleDTO implements ModelDTO
{
    /**
     * @param string $title
     */
    public function __construct(
        public readonly string $title,
    )
    {
    }

    /**
     * @param UserRoleRequest $request
     * @return UserRoleDTO
     */
    public static function appRequest(UserRoleRequest $request): UserRoleDTO
    {
        return new UserRoleDTO(
            $request['title'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
