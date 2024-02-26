<?php

use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('votings', VotingController::class, ['store', 'update', 'show']);

Route::get('vote/{suggestionUuid}/{email}', '\App\Http\Controllers\VoteController@show');

Route::resource('confirmations', ConfirmationController::class, ['store', 'update']);
