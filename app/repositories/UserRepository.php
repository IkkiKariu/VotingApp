<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\UserDTO;


class UserRepository
{
    public function getUserById(int $id) : User|null
    {
        return User::where('id', $id)->first();
    }

    public function getUserByLogin(string $login) : User
    {
        return User::where('login', $login)->first();
    }

    public function getAllUsers() : Collection 
    {
        return User::all();
    }

    public function createUser(UserDTO $user)
    {
        $newUser = new User;

        $newUser->login = $user->login;
        $newUser->password = $user->password;
        $newUser->name = $user->name;
        $newUser->bio = $user->bio;

        $newUser->save();
    }
}