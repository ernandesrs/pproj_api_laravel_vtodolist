<?php

namespace App\Services;

use App\Exceptions\LoginInvalidException;

class AuthService
{
    /**
     * @param string $email
     * @param string $pass
     * @return array
     * @throws LoginInvalidException
     */
    public function login(string $email, string $pass)
    {
        $login = [
            'email' => $email,
            'password' => $pass
        ];

        $token = auth()->attempt($login);
        if (!$token) {
            throw new LoginInvalidException();
        }

        return [
            "access_token" => $token,
            "token_type" => 'Bearer',
        ];
    }
}
