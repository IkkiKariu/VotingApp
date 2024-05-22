<?php

namespace App\Services;

class SurveyService
{
    public function generateUid(): string
    {
        $uid = uniqid(more_entropy: true);

        return $uid;
    }

    
}