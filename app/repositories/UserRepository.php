<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\UserDTO;
use App\Models\PersonalAccessToken;

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

    private function getUserByToken(string $token): User|null
    {
        $user = PersonalAccessToken::where('token', hash('sha256', explode('|', $token)[1]))->first()->user;

        return $user;
    }

    public function getUser(string $token)
    {
        $user = $this->getUserByToken($token);

        $userDto = new UserDTO($user->login, $user->password, $user->name, $user->bio);

        return $userDto;
    }

    public function updateUser(string $token, UserDTO $userData)
    {
        $user = $this->getUserByToken($token);

        if ($user->name != $userData->name)
        {
            $user->name = $userData->name;    
        }

        if ($user->bio != $userData->bio)
        {
            $user->bio = $userData->bio;    
        }
        
        $user->save();
    }

    public function deleteUser(string $token)
    {
        $user = $this->getUserByToken($token);
        
        $user->delete();
    }
}