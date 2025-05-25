<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\UserRequest;

class UserDTO implements ModelDTO
{
    /**
     * @param string $name
     * @param string $surname
     * @param string|null $image_path
     */
	public function __construct(
		public readonly string $name,
		public readonly string $surname,
		public readonly string|null $image_path,
	) {}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return array_merge([
			'name' => $this->name,
			'surname' => $this->surname,
        ], $this->image_path ? ['image_path' => $this->image_path]  : []);
	}
}
