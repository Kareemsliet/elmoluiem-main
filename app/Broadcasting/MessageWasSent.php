<?php

namespace App\Broadcasting;

use App\Models\Student;
use Musonza\Chat\Facades\ChatFacade as Chat;

class MessageWasSent
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Student $user,$conversation_id): array|bool
    {
        $conversation = Chat::conversations()->setParticipant($user)->getById($conversation_id);
        
        return $conversation?true:false;
    }
}
