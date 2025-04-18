<?php

use App\Broadcasting\MessageWasSent;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
},
    ['guards' => ['sanctum']]
);

Broadcast::channel("chat-conversation.{conversation_id}",MessageWasSent::class,["guard"=>"sanctum"]);
