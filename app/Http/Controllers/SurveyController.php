<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SurveyRepository;
use App\DTO\CreateSurveyDTO;
use App\Models\PersonalAccessToken;

class SurveyController extends APIController
{
    protected SurveyRepository $repository;
    
    
    public function __construct(SurveyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $token = $request->bearerToken();

        $surveys = $this->repository->getParticipatedSurveys($token);

        return response()->json(['response_status' => 'success', 'data' => $surveys != null ? $surveys->toArray() : null]);
    }

    public function show(Request $request)
    {
        $data = $request->json()->all();
        $survey = $this->repository->getSurveyData($data['survey_public_uid']);

        return response()->json($survey != null ? $survey->toArray() : null);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $this->repository->createSurvey($request->bearerToken(), new CreateSurveyDTO($data['title'],
                                                                                     $data['content'],
                                                                                     $data['hasMultipleChoice'],
                                                                                     $data['decisions']));

        
    }

    public function delete(Request $request)
    {
        $data = $request->json()->all();
        $token = $request->bearerToken();

        $complete_status = $this->repository->deleteSurvey($token, $data['survey_public_uid']);

        if(!$complete_status)
        {
            return response()->json(['response_status' => 'failure']);
        }

        return response()->json(['response_status' => 'success']);
    }

    public function isVoted(Request $request)
    {
        $data = $request->json()->all();
        $token = $request->bearerToken();

        if(!$this->validateJsonRequest($data, ['survey_public_uid' => 'required']))
        {
            return response()->json(['response_status' => 'failure']);
        }

        if($this->repository->getParticipation($token, $data['survey_public_uid']))
        {
            return response()->json(['response_status' => 'success', 'data' => ['is_participated' => true]]);
        }
        else{
            return response()->json(['response_status' => 'success', 'data' => ['is_participated' => false]]);
        }
    }
}
