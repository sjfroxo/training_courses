<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\LoginUserRequest;

class LoginUserDTO implements ModelDTO
{

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password
    )
    {

    }

    /**
     * @param LoginUserRequest $request
     * @return LoginUserDTO
     */
    public static function appRequest(LoginUserRequest $request): LoginUserDTO
    {
        return new LoginUserDTO(
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
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
