<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', [UserController::class, "getUser"]);
    Route::get('/channels', [ChannelController::class, 'getUserChannels']);
    Route::post('/channels', [ChannelController::class, 'store']);
    Route::get('/channels/{channelId}/messages', [ChannelController::class, 'getChannelMessages']);
    Route::get('/channels/{channelId}/members', [ChannelController::class, 'getChannelMembers']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/search-users', [UserController::class, 'search']);
    Route::delete('/channels/{channelId}/users/{userId}', [ChannelController::class, 'removeUser']);
});

// Route::post('/send-message', function (Request $request) {
//     $message = $request->input('message');

//     broadcast(($message))->toOthers();

//     return response()->json(['status' => 'Message Sent!']);
// });

Route::post("/auth", [PersonalAccessTokenController::class, "store"]);