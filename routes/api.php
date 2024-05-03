<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuthTokenIsValid;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix('/user')->group(function() {
    Route::get('/', [UserController::class, 'show'])->name('user.show')->middleware(EnsureAuthTokenIsValid::class);
    Route::get('/delete', [UserController::class, 'delete'])->name('user.delete')->middleware(EnsureAuthTokenIsValid::class);
    }
);

Route::get('/surveys/participated/{user_id}', [SurveyController::class, 'index'])->name('surveys.participated.index');
Route::get('/surveys/{survey_uid}', [SurveyController::class, 'show'])->name('surveys.show');
// Route::prefix('/user'. function()
// {
//
// });

Route::get('/test', function()
{
    return "SUCCESS";
})->middleware(EnsureAuthTokenIsValid::class);

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');


Route::post('/login', [AuthController::class, 'login'])->name('login.store');
