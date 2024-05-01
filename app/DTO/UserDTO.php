<?php
namespace App\DTO;

class UserDTO
{
    readonly string $login;
    readonly string $password;
    readonly string $name;
    readonly string|null $bio;

    public function __construct(string $login, string $password, string $name, string|null $bio)
    {
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
        $this->bio = $bio; 
    }
}