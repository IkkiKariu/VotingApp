<?php

namespace App\Services;

use App\Models\User;
use App\Models\PersonalAccessToken;

class AuthenticationService
{
    public function authenticate(string $login, string $password)
    {
        $guessedUser = User::where('login', $login)->first();
        
        // credentials are invalid there
        if(!$guessedUser)
        {
            return null;
        }

        if ($guessedUser->password != $password)
        {
            return null;
        }

        
        // credentials are valid there
        
        $token = $guessedUser->createToken('authToken');

        return $token->plainTextToken;
    }

    public function tokenIsValid(string|null $token): bool
    {
        if(!$token)
        {
            return false;
        }

        $guessedToken = PersonalAccessToken::where('token', hash('sha256', explode('|', $token)[1]))->first();

        return $guessedToken ? true : false; 
    }
}

?>