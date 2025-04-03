<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        return view("user.profile.index", get_defined_vars());
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = explode(".", $image->getClientOriginalName())[0];
            $imagePath = uploadFile($image, "uploads/profilePictures", $imageName);
        }
        $user = User::whereId(Auth::id())->first();
        $user->image = isset($imagePath) ? $imagePath : $user->image;
        $user->name = isset($inputs['name']) ? $inputs['name'] : $user->name;
        $user->save();

        return back();
    }
}
