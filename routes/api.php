<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuthTokenIsValid;

Route::prefix('/user')->group(function() {
    Route::get('/', [UserController::class, 'show'])->name('user.show')->middleware(EnsureAuthTokenIsValid::class);
    Route::get('/delete', [UserController::class, 'delete'])->name('user.delete')->middleware(EnsureAuthTokenIsValid::class);
    }
);

Route::prefix('/survey')->group(function() {
    Route::post('/create', [SurveyController::class, 'store'])->middleware(EnsureAuthTokenIsValid::class)->name('survey.create');
    Route::post('/delete', [SurveyController::class, 'delete'])->middleware(EnsureAuthTokenIsValid::class)->name('survey.delete');
    Route::post('/decision/vote', [VoteController::class, 'store'])->middleware(EnsureAuthTokenIsValid::class);
    Route::post('/decision/votes/reset', [VoteController::class, 'delete'])->middleware(EnsureAuthTokenIsValid::class);
    Route::get('/participated', [SurveyController::class, 'index'])->middleware(EnsureAuthTokenIsValid::class);
    Route::post('/show', [SurveyController::class, 'show'])->middleware(EnsureAuthTokenIsValid::class);
    Route::post('/isVoted', [SurveyController::class, 'isVoted'])->middleware(EnsureAuthTokenIsValid::class);
});

Route::get('/test', function()
{
    return "SUCCESS";
})->middleware(EnsureAuthTokenIsValid::class);

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');


Route::post('/login', [AuthController::class, 'login'])->name('login.store');
