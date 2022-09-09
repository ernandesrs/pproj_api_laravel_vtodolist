<?php

namespace App\Services;

use App\Exceptions\UserHasBeenTakenException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param User $user
     * @param array $input
     * @return User
     */
    public function update(User $user, array $input)
    {
        if (!empty($input["email"]) && User::where("email", $input["email"])->where("email", "!=", $user->email)->exists()) {
            throw new UserHasBeenTakenException();
        }

        if (!empty($input["password"])) {
            $input["password"] = Hash::make($input["password"]);
        }

        $user->fill($input);
        $user->save();

        return $user->fresh();
    }
}
