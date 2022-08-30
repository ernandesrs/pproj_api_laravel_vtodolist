<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     * @throws UserHasBeenTakenException
     */
    public function register(string $firstName, string $lastName, string $email, string $password)
    {
        $user = User::where("email", $email)->exists();
        if (!empty($user)) {
            throw new UserHasBeenTakenException();
        }

        $userPassword = Hash::make($password);

        $user = User::create([
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "password" => $userPassword,
            "confirmation_token" => Str::random(10)
        ]);

        event(new UserRegistered($user));

        return $user;
    }
}
