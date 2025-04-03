<?php

namespace App\Broadcasting;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NewMessage
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
    public function join(User $user, $channelName): bool
    {

        $channel = Channel::whereName($channelName)->where(function($q) use($user){
            $q->where('user1_id', $user->id)->orWhere('user2_id', $user->id);
        })->first();

        if(!$channel)
        {
            return false;
        }

        return true;
    }
}
