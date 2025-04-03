<?php

use App\Broadcasting\NewMessage;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel-{channel_name}', NewMessage::class);
