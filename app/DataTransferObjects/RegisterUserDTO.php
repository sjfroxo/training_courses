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
     * @param RegisterUserRequest $request
     * @return RegisterUserDTO
     */
    public static function appRequest(RegisterUserRequest $request): RegisterUserDTO
    {
        return new RegisterUserDTO(
            $request['name'],
            $request['surname'],
            $request['email'],
            $request['password'],
        );
    }

    /**
     * @return array|mixed[]
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
