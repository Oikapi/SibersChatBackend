<?php

use App\Http\Controllers\ChannelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalAccessTokenController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/channels', [ChannelController::class, 'getUserChannels']);
    Route::get('/channels/{channelId}/messages', [ChannelController::class, 'getChannelMessages']);
    Route::get('/channels/{channelId}/members', [ChannelController::class, 'getChannelMembers']);
});

Route::post("/auth", [PersonalAccessTokenController::class, "store"]);