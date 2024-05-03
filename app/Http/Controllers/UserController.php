<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use Illuminate\Http\Request;
use App\Models\User;
use Nette\Utils\Json;
use App\Repositories\UserRepository;



class UserController extends Controller
{

    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;      
    }

    public function show(Request $request)
    {
        $token = $request->bearerToken();

        $user = $this->repository->getUser($token);

        return response()->json(['response_status' => 'success',
            'data' => [
                'login' =>  $user->login,
                'password' => $user->password,
                'name' => $user->name,
                'bio' => $user->bio
            ]
        ]);
    }

    public function store(Request $request)
    {
        
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $token = $request->bearerToken();

        $this->repository->updateUser($token, new UserDTO(null, null, $data['name'], $data['bio']));

        return response()->json(['response_status' => 'success']);
    }

    public function delete(Request $request)
    {
        $token = $request->bearerToken();

        $this->repository->deleteUser($token);

        return response()->json(['response_status' => 'success']);
    }
}
