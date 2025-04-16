<?php

use App\Http\Controllers\Api\ChatController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix"=>"/chat/a/","middleware"=>["auth:sanctum","hasVerified"]],function(){
    Route::get("/conversations",[ChatController::class,"conversations"]);
    Route::get("/{conversation_id}",[ChatController::class,"conversation"]);
    Route::post("/{conversation_id}/clear",[ChatController::class,"clearConversation"]);    
    Route::group(["prefix"=>"/{conversation_id}/messages/{message_id}/"],function(){
        Route::post("/delete",[ChatController::class,"deleteMessage"]);
        Route::post("/flag/toggle",[ChatController::class,"toggleFlagMessage"]);
    });
    Route::get("/messages/flagged",[ChatController::class,"flaggedMessages"]);
    Route::post("/{conversation_id}/messages/create",[ChatController::class,"createMessage"]);
    Route::post("/conversations/{user_id}/new",[ChatController::class,"createConversation"]);
    Route::post("/conversations/{user_id}/hide",[ChatController::class,"hideConversation"]);
});