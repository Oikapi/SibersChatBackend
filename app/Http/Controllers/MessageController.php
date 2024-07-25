<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();

        // return inertia("Message/Index", compact(",essages"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate(
            [
                "channel_id" => "required|integer",
                "message" => "string|required"
            ]
        );
        // dd($data);
        $user = auth()->user(); // Получение текущего аутентифицированного пользователя
        $channelId = $data['channel_id']; // Предполагается, что channel_id передается в запросе

        // Проверка, состоит ли пользователь в канале
        if (!$this->userBelongsToChannel($user, $channelId)) {

            return response()->json(['error' => 'Unauthorized'], 405);
        }

        // Создание сообщения
        $message = Message::createMessage($data, $user);

        event(new StoreMessageEvent($message, $channelId));
        // Вещание события другим пользователям
        // broadcast(new MessageResource($message))->toOthers();

        return new MessageResource($message);
    }

    private function userBelongsToChannel($user, $channelId)
    {
        return $user->channels()->where('channels.id', $channelId)->exists();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
