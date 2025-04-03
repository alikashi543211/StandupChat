<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat()
    {
        $user = User::where('id', Auth::id())->first();

        $channels = $user->contactsAddedByMe->merge($user->contactsAddedByOther);

        if(count($channels) == 0)
        {
            return redirect()->to('user/contacts/add');
        }

        $currentChannel = $channels->first();
        $contacts = array_merge($user->contactsAddedByOther->pluck('user1_id')->toArray(), $user->contactsAddedByMe->pluck('user2_id')->toArray());
        $users = User::whereIn('id', $contacts)->get();
        if($currentChannel->user1->id == Auth::id())
        {
            $activeChatUser = $currentChannel->user2;
        }else{
            $activeChatUser = $currentChannel->user1;
        }

        $messages = [];

        $latestMessage = Message::whereHas('channel', function($q){

            $q->where('user1_id', Auth::id())->orWhere('user2_id', Auth::id());

        })
        ->orderBy('id', 'DESC')
        ->with('channel')
        ->first();

        if($latestMessage)
        {

            if($latestMessage->channel->user1_id == Auth::id())
            {

                $activeChatUser = User::whereId($latestMessage->channel->user2_id)->first();

            }

        }

        return view("chat.index", get_defined_vars());

    }

    public function checkChannelExists(Request $request)
    {
        $result = true;

        $inputs = $request->all();

        $channel = Channel::where(function($q) use($inputs){

            $q->where('user1_id', $inputs['user_id'])
                ->where('user2_id', Auth::id());

        })->orWhere(function($q) use($inputs){

            $q->where('user1_id', Auth::id())
                ->where('user2_id', $inputs['user_id']);

        })->first();

        if(!$channel)
        {
            $result = false;
        }

        return response()->json([
            'success' => 1,
            'message' => 'Success',
            'data'    => [
                'data' => $channel,
                'channelExists' => $result,
            ],
        ]);


    }

    public function createChannel(Request $request)
    {
        $inputs = $request->all();

        $newChannel = new Channel();
        $newChannel->user1_id = Auth::id();
        $newChannel->user2_id = $inputs['user_id'];
        $newChannel->name = "chat-" . min(Auth::id(), $inputs['user_id']) . '-' . max(Auth::id(), $inputs['user_id']);
        $newChannel->save();

        return response()->json([
            'success' => 1,
            'message' => 'Channel Created Successfully',
            'data'    => [
                'data' => $newChannel->fresh(),
            ],

        ]);

    }

    public function loadChatMessages(Request $request)
    {
        $inputs = $request->all();

        $user = User::where('id', Auth::id())->first();

        $channels = $user->contactsAddedByMe->merge($user->contactsAddedByOther);

        if(count($channels) == 0)
        {
            return response()->json(['error' => '0 Channel Found']);
        }

        $currentChannel = $channels->first();

        if($currentChannel->user1->id == Auth::id())
        {
            $activeChatUser = $currentChannel->user2;
        }else{
            $activeChatUser = $currentChannel->user1;
        }

        $messages = [];

        $latestMessage = Message::whereHas('channel', function($q){

            $q->where('user1_id', Auth::id())->orWhere('user2_id', Auth::id());

        })
        ->orderBy('id', 'DESC')
        ->with('channel')
        ->first();
        if($latestMessage)
        {

            if($latestMessage->channel->user1->id == Auth::id())
            {

                $activeChatUser = $latestMessage->channel->user2;

            }else{

                $activeChatUser = $latestMessage->channel->user1;

            }

            $messages = Message::whereChannelId($latestMessage->channel_id)->get();

            $currentChannel = $latestMessage->channel;

        }

        $messages = view('chat.ajax.messages', get_defined_vars())->render();

        $activeChatUserView = view('chat.ajax.activeChatUser', get_defined_vars())->render();
        Log::info(User::whereId(Auth::user()->id)->first()->image);
        return response()->json([
            'success' => 1,
            'message' => 'Data Fetched Successfully',
            'data'    => [
                'data' => $messages,
                'activeChatUser' => $activeChatUserView,
                'currentChannelName' => $currentChannel->name,
                'activeChatUserId' => $activeChatUser->id,
                'userProfileImage' => User::whereId(Auth::user()->id)->first()->image
            ],

        ]);

    }

    public function loadChannelMessages(Request $request)
    {

        $inputs = $request->all();

        $activeChatUser = User::whereId($inputs['user_id'])->first();

        $channel = Channel::where(function($q) use($inputs){

            $q->where('user1_id', $inputs['user_id'])
                ->where('user2_id', Auth::id());

        })->orWhere(function($q) use($inputs){

            $q->where('user1_id', Auth::id())
                ->where('user2_id', $inputs['user_id']);

        })->first();

        if(!$channel)
        {

            return response()->json([
                'success' => 0,
                'message' => 'Channel Does Not Exist',
                'data'    => [
                    'data' => [
                        'data' => '',
                        'activeChatUserId' => null,
                    ]
                ],

            ]);

        }

        $messages = Message::whereChannelId($channel->id)->get();

        $messages = view('chat.ajax.messages', get_defined_vars())->render();

        $activeChatUserView = view('chat.ajax.activeChatUser', get_defined_vars())->render();

        return response()->json([
            'success' => 1,
            'message' => 'Data Fetched Successfully',
            'data'    => [
                'data' => $messages,
                'activeChatUser' => $activeChatUserView,
                'activeChatUserId' => $activeChatUser->id,
                'userProfileImage' => User::whereId(Auth::user()->id)->first()->image
            ],

        ]);

    }

    public function broadcastMessage(Request $request)
    {

        $inputs = $request->all();

        $channel = Channel::whereName($inputs['channel'])->first();

        $newMessage = new Message();
        $newMessage->user_id = Auth::id();
        $newMessage->message = $inputs['message'];
        $newMessage->channel_id = $channel->id;
        $newMessage->save();

        broadcast(new NewMessageEvent($newMessage, $channel))->toOthers();

        return response()->json([
            'success' => 1,
            'message' => 'Message Sent Successfully.',
            'data'    => [
                'data' => $newMessage->fresh(),
            ],

        ]);

    }

    public function broadcastImages(Request $request)
    {

        $inputs = $request->all();

        $channel = Channel::whereName($inputs['channel'])->first();

        if(count($inputs['images']) > 0)
        {

            foreach($request->file('images') as $imageKey => $image)
            {
                $imageName = explode(".", $image->getClientOriginalName())[0];

                $imagePath = uploadFile($image, "uploads", $imageName);

                if($imagePath)
                {
                    $newMessage = new Message();
                    $newMessage->user_id = Auth::id();
                    $newMessage->message = "attachment";
                    $newMessage->attachments = $imagePath;
                    $newMessage->channel_id = $channel->id;
                    $newMessage->save();
                }

                broadcast(new NewMessageEvent($newMessage, $channel))->toOthers();
            }

        }

        return response()->json([
            'success' => 1,
            'message' => 'Images Sent Successfully.',
            'data'    => [
                'data' => [],
            ],

        ]);





    }


}
