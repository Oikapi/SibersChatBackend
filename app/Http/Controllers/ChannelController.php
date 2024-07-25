<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Channel;
use App\Models\User;
use App\Models\Message;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ChannelController extends Controller
{
    public function getUserChannels()
    {
        $user = Auth::user();

        // Получение всех каналов пользователя
        $channels = $user->channels()->get();

        // Возвращаем каналы в формате JSON
        return response()->json($channels);
    }

    public function getChannelMessages($channelId)
    {
        // Получение канала по ID
        $channel = Channel::findOrFail($channelId);

        $messages = $channel->messages()->with('user:id,name')->get();

        // Возвращаем сообщения с использованием ресурсного класса
        return MessageResource::collection($messages);
        // // Получение сообщений канала
        // $messages = $channel->messages()->get();

        // // Возвращаем сообщения в формате JSON
        // return response()->json($messages);
    }

    public function getChannelMembers($channelId)
    {
        // Получение канала по ID
        $channel = Channel::findOrFail($channelId);

        // Получение пользователей канала
        $users = $channel->users()->get(['name']);

        // Возвращаем ники пользователей в формате JSON
        return response()->json($users);
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $user = auth()->user();

        // Логика сохранения сообщения

        broadcast(new MessageResource($message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

    public function store(Request $request)
    {
        // return ($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
        ]);

        $channel = Channel::create(['name' => $request->name]);

        // Attach the authenticated user and the specified users to the channel
        $channel->users()->attach(array_merge($request->users, [Auth::id()]));

        return response()->json([
            'message' => 'Channel created successfully',
            'channel' => $channel
        ], 201);
    }

    public function removeUser(Request $request, $channelId, $userId)
    {
        $channel = Channel::findOrFail($channelId);

        // Ensure the current user is the creator of the channel
        if (Auth::id() !== $channel->created_by) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Detach the user from the channel
        $channel->users()->detach($userId);

        return response()->json(['message' => 'User removed from channel']);
    }
}
