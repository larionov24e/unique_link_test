<?php

namespace App\Services;

use App\Models\User;

final class UserService
{
    /**
     * @param string $name
     * @param string $phoneNumber
     * @return User
     */
    public function createUser(string $name, string $phoneNumber): User
    {
        $user = User::where('phonenumber', $phoneNumber)->first();

        if ($user) {
            return $user;
        }

        return User::create(
            [
                'name' => $name,
                'phonenumber' => $phoneNumber,
            ]
        );
    }
}
