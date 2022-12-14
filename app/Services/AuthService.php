<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Models\PasswordReset;
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

    /**
     * @param string $token
     * @return User
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(string $token)
    {
        $user = User::where("confirmation_token", $token)->first();
        if (empty($user))
            throw new VerifyEmailTokenInvalidException();

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    /**
     * @param string $email
     * @return void
     */
    public function forgotPassword(string $email)
    {
        $user = User::where("email", $email)->firstOrFail();

        $token = Str::random(60);
        PasswordReset::create([
            'email' => $user->email,
            'token' => $token
        ]);

        event(new ForgotPassword($user, $token));

        return;
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $token
     * @return void
     * @throws ResetPasswordTokenInvalidException
     */
    public function resetPassword(string $email, string $password, string $token)
    {
        $passReset = PasswordReset::where("email", $email)->where("token", $token)->first();

        if (empty($passReset)) {
            throw new ResetPasswordTokenInvalidException();
        }

        $user = User::where("email", $email)->firstOrFail();
        $user->password = Hash::make($password);
        $user->save();

        PasswordReset::where("email", $email)->delete();

        return;
    }
}
