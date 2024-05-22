<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SurveyRepository;

class VoteController extends APIController
{
    protected SurveyRepository $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $token = $request->bearerToken();

        if($this->surveyRepository->createVote($token, $data['survey_public_uid'], $data['decision_id']))
        {
            return response()->json(['response_status' => 'success']);
        }
        else
        {
            return response()->json(['response_status' => 'failure']);
        }
    }

    public function delete(Request $request)
    {
        $data = $request->json()->all();
        $token = $request->bearerToken();

        if($this->surveyRepository->deleteVotes($token, $data['survey_public_uid'], $data['decision_id_list']))
        {
            return response()->json(['response_status' => 'success']);
        }
        else
        {
            return response()->json(['response_status' => 'failure']);
        }
    }
}
    