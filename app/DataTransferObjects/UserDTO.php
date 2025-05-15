<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\UserRequest;

class UserDTO implements ModelDTO
{
    /**
     * @param string $name
     * @param string $surname
     * @param string $image_path
     */
	public function __construct(
		public readonly string $name,
		public readonly string $surname,
		public readonly string $image_path,
	) {}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'name' => $this->name,
			'surname' => $this->surname,
			'image_path' => $this->image_path,
		];
	}
}
