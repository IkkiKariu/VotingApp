<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SurveyRepository;


class SurveyController extends Controller
{
    protected SurveyRepository $repository;
    
    
    public function __construct(SurveyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(int $user_id)
    {
        $surveys = $this->repository->getParticipatedSurveys($user_id);

        return $surveys != null ? $surveys->toArray() : null;
    }

    public function show(string $uid)
    {
        $survey = $this->repository->getSurveyData($uid);

        return $survey != null ? $survey->toArray() : null;
    }
}
