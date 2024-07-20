<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\User;
use App\Models\Message;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use Illuminate\Support\Facades\Auth;


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

        // Получение сообщений канала
        $messages = $channel->messages()->get();

        // Возвращаем сообщения в формате JSON
        return response()->json($messages);
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
}
