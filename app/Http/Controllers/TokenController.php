<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class TokenController extends APIController
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $this->validateJsonRequest($data, ['login' => 'required', 'password']);
    }
}
