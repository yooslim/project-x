<?php

namespace Domains\Authentication\Repositories;

use Domains\Authentication\Exceptions\UserNotFoundException;
use Domains\Authentication\Exceptions\WrongCrendentialsException;
use Domains\Authentication\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class UserRepository
{
    public function getToken(string $email, string $password): NewAccessToken
    {
        $user = User::where('email', $email)->first();

        if (!$user) throw new UserNotFoundException();

        if (!Hash::check($password, $user->password)) throw new WrongCrendentialsException();

        return $user->createToken('access_token');
    }
}
