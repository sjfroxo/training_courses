<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\UserRequest;

class UserDTO implements ModelDTO
{
	/**
	 * @param string $surname
	 * @param string $name
	 */
	public function __construct(
		public readonly string $name,
		public readonly string $surname,
	) {}

	/**
	 * @param UserRequest $request
	 *
	 * @return UserDTO
	 */
	public static function appRequest(UserRequest $request): UserDTO
	{
		return new UserDTO(
			$request['name'],
			$request['surname'],
		);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'name' => $this->name,
			'surname' => $this->surname,
		];
	}
}
