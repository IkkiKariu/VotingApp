<?php

namespace App\Repositories;

use App\Models\Participation;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;

class SurveyRepository
{
    public function getCreatedSurveys(int $userId) : Collection
    {
        return Survey::where('creator_id', $userId)->get();
    }

    public function getParticipatedSurveys(int $userId) : Collection|null
    {
        return Participation::with('survey')->where('user_id', $userId)->get();
    }

    public function getSurveyData(string $uid) : Survey|null
    {
        return Survey::with(['decisions.votes.user', 'creator'])->where('public_uid', $uid)->first();
    }
}