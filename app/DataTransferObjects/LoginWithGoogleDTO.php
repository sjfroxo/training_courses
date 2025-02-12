<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\LoginWithGoogleRequest;
use App\Http\Requests\RegisterUserRequest;
class LoginWithGoogleDTO implements ModelDTO
{

    /**
     * @param string $email
     * @param string $name
     * @param string $surname
     * @param string $google_id
     */
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $google_id
    )
    {
    }


    /**
     * @param LoginWithGoogleRequest $request
     * @return LoginWithGoogleDTO
     */
    public static function appRequest(LoginWithGoogleRequest $request): LoginWithGoogleDTO
    {
        return new LoginWithGoogleDTO(
            $request['email'],
            $request['name'],
            $request['surname'],
            $request['google_id'],
        );
    }

    /**
     * @return array|mixed[]
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'surname' => $this->surname,
            'google_id' => $this->google_id
        ];
    }
}
