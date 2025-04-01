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
