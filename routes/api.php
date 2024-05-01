<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/users/{user_id}', [UserController::class, 'show'])->name('users.show');

Route::get('/surveys/participated/{user_id}', [SurveyController::class, 'index'])->name('surveys.participated.index');
Route::get('/surveys/{survey_uid}', [SurveyController::class, 'show'])->name('surveys.show');
// Route::prefix('/user'. function()
// {
//
// });

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');


Route::post('/login', [AuthController::class, 'login'])->name('login.store');
