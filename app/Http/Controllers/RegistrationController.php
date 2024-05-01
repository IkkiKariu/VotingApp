<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\UserDTO;
use App\Repositories\UserRepository;

class RegistrationController extends APIController
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        if (!$this->validateJsonRequest($data, ['login' => 'required', 'password' => 'required', 'name' => 'required']))
        {
            return response()->json(['response_status' => 'failure']);
        }

        $this->repository->createUser(new UserDTO($data['login'], $data['password'], $data['name'], null));

        $createdUser = $this->repository->getUserByLogin($data['login']);
        return response()->json(["response_status" => "success", "data" => $createdUser->toArray()]);    
    }
}
