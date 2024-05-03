<?php
namespace App\DTO;

class UserDTO
{
    readonly string|null $login;
    readonly string|null $password;
    readonly string|null $name;
    readonly string|null $bio;

    public function __construct(string|null $login, string|null  $password, string|null $name, string|null $bio)
    {
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
        $this->bio = $bio; 
    }
}