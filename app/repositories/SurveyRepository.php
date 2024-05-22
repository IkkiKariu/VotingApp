<?php

namespace App\Repositories;

use App\Models\Participation;
use App\Models\Survey;
use App\Models\User;
use App\Models\PersonalAccessToken;
use App\Models\Decision;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\CreateSurveyDTO;
use App\Services\SurveyService;
use App\Models\Vote;

class SurveyRepository
{
    private SurveyService $surveyService;


    public function __construct()
    {
        $this->surveyService = new SurveyService();    
    }

    public function getCreatedSurveys(int $userId) : Collection
    {
        return Survey::where('creator_id', $userId)->get();
    }

    public function getParticipatedSurveys(string $userToken) : Collection|null
    {
        $user = $this->getUserByToken($userToken);
        return Participation::with('survey')->where('user_id', $user->id)->get();
    }

    public function getSurveyData(string $uid) : Survey|null
    {
        return Survey::with(['decisions.votes.user', 'creator'])->where('public_uid', $uid)->first();
    }

    private function getUserByToken(string $token)
    {
        $user = PersonalAccessToken::where('token', hash('sha256', explode('|', $token)[1]))->first()->user;

        return $user;
    }

    public function createSurvey(string $creatorToken, CreateSurveyDTO $createSurveyDto)
    {
        $creator = $this->getUserByToken($creatorToken);
        $surveyUid = $this->surveyService->generateUid();
        
        $newSurvey = new Survey();
        
        $newSurvey->creator_id = $creator->id;
        $newSurvey->title = $createSurveyDto->title;
        $newSurvey->content = $createSurveyDto->content;
        $newSurvey->public_uid = $surveyUid;
        $newSurvey->has_multiple_choice = $createSurveyDto->hasMultipleChoice;

        $newSurvey->save();

        $createdSurvey = Survey::where('public_uid', $surveyUid)->first();

        foreach($createSurveyDto->decisions as $decision)
        {
            $newDecision = new Decision();

            $newDecision->survey_id = $createdSurvey->id;
            $newDecision->content = $decision['content'];

            $newDecision->save();
        }    
    }

    public function deleteSurvey(string $userToken, string $publicUid): bool
    {
        $user = $this->getUserByToken($userToken);

        $survey = Survey::where('public_uid', $publicUid)->first();

        if ($survey->creator_id != $user->id)
        {
            return false;
        }
        
        $survey->delete();

        return true;
    }

    public function createVote(string $userToken, string $surveyPublicUid, string $decisionId): bool
    {
        $user = $this->getUserByToken($userToken);

        $survey = Survey::where('public_uid', $surveyPublicUid)->first();

        $decision = Decision::where('id', $decisionId)->first();

        $guessedVote = Vote::where('decision_id', $decisionId)->where('user_id', $user->id)->first();

        if($guessedVote)
        {
            return false;
        }

        if($survey->has_multiple_choice)
        {
            $newVote = new Vote();

            $newVote->decision_id = $decisionId;
            $newVote->user_id = $user->id;

            $newVote->save();

        }
        else
        {
            if(Participation::where('user_id', $user->id)->where('survey_id', $survey->id)->first())
            {
                return false;
            }

            $newVote = new Vote();

            $newVote->decision_id = $decisionId;
            $newVote->user_id = $user->id;

            $newVote->save();

        }

        $participation = new Participation();

        $participation->user_id = $user->id;
        $participation->survey_id = $survey->id;

        $participation->save();

        $decision->vote_count += 1;
        $decision->save();
        
        return true;
    }

    public function deleteVotes(string $userToken, string $surveyPublicUid, array $decisionIdList): bool
    {
        $guessedSurvey = Survey::where('public_uid', $surveyPublicUid)->first();

        if(!$guessedSurvey || !$decisionIdList)
        {
            return false;
        }

        $user = $this->getUserByToken($userToken);

        foreach($decisionIdList as $key => $value)
        {
            $decision = Decision::where('id', $value)->first();

            if(!$decision)
            {
                return false;
            }

            if($decision->survey_id != $guessedSurvey->id)
            {
                return false;
            }
        }

        foreach($decisionIdList as $key => $value)
        {
            $vote = Vote::where('decision_uid', $value)->where('user_id', $user->id)->first();

            if(!$vote)
            {
                return false;
            }
        }

        if(!Participation::where('user_id', $user->id)->where('survey_id', $guessedSurvey->id)->first())
        {
            return false;
        }

        foreach($decisionIdList as $key => $value)
        {
            $vote = Vote::where('decision_uid', $value)->where('user_id', $user->id)->first();

            $vote->delete();
        }

        $participation = Participation::where('user_id', $user->id)->where('survey_id', $guessedSurvey->id)->first();
        $participation->delete();

        return true;
    }
}