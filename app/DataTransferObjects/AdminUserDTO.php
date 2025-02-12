<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\AdminUserRequest;
use App\Http\Requests\UserRequest;

class AdminUserDTO implements ModelDTO
{
	/**
	 * @param string $user_role_id
	 * @param string $name
	 * @param string $surname
	 * @param string $email
	 * @param string $password
	 */
	public function __construct(
		public readonly string $user_role_id,
		public readonly string $name,
		public readonly string $surname,
		public readonly string $email,
		public readonly string $password,
	) {}

	/**
	 * @param AdminUserRequest $request
	 *
	 * @return AdminUserDTO
	 */
	public static function appRequest(AdminUserRequest $request): AdminUserDTO
	{
		return new AdminUserDTO(
			$request['user_role_id'],
			$request['name'],
			$request['surname'],
			$request['email'],
			$request['password'],
		);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'user_role_id' => $this->user_role_id,
			'name' => $this->name,
			'surname' => $this->surname,
			'email' => $this->email,
			'password' => $this->password,
		];
	}
}
