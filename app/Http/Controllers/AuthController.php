<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthenticationService;

class AuthController extends APIController
{
    protected AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $data = $request->json()->all();

        // required data is invalid
        if(!$this->validateJsonRequest($data, ['login' => 'required', 'password' => 'required']))
        {
            return response()->json(['response_status' =>'failure']);
        }

        // required data is valid

        $token = $this->authService->authenticate($data['login'], $data['password']);

        // credentials are invalid
        
        if(!$token)
        {
            return response()->json(['response_status' => 'failure']);
        }

        //credentials are valid

        return response()->json(['response_status' => 'success', 'data' => $data, 'auth_token' => $token]);
    }
}
