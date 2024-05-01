<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    protected function validateJsonRequest(array $content, array $required)
    {
        if (array_diff(array_keys($required), array_keys($content)) == []) 
        {
            $validator = Validator::make($content, $required);
    
            if ($validator->fails()) {
                return false;
            }

            return true;
        }

        return false;
    }
}
