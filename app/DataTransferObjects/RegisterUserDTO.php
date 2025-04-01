<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\RegisterUserRequest;
class RegisterUserDTO implements ModelDTO
{

    /**
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $password
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
