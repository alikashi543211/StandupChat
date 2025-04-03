<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index()
    {
        return view("user.contacts.add", get_defined_vars());
    }

    public function addContact(Request $request)
    {
        $inputs = $request->all();
        Session::flash('phone_number', $inputs['phone_number']);
        if(!$user = User::wherePhoneNumber($inputs['phone_number'])->first())
        {
            errorFlashMessage(ERROR_MESSAGE_ACCOUNT_NOT_FOUND);
            return back();
        }

        $newChannel = new Channel();
        $newChannel->user1_id = Auth::id();
        $newChannel->user2_id = $user->id;
        $newChannel->name = $newChannel->name = "chat-" . min(Auth::id(), $user->id) . '-' . max(Auth::id(), $user->id);
        $newChannel->save();

        successFlashMessage(SUCCESS_MESSAGE_CONTACT_ADDED);
        return redirect()->to('/');
    }
}
