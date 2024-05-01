<?php

namespace App\Http\Controllers;

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

        // $user = $this->repository->getUserById($user_id);
        
        // $resp = $user != null ? $user->toJson() : null;
        
        // return response()->json($resp);
    }

    public function store(Request $request)
    {
        
    }   
}
