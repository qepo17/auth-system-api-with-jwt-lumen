<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
    }
    public function show(Request $request, $username)
    {
        return User::where('username', $username)->firstOrfail();
    }
    public function update(Request $request, $username)
    {
        $this->validate($request, [
            'username' => 'unique:users,username|min:5|max:25',
            'name' => 'string',
            'email' => 'unique:users,email|email',
            'password' => 'min:8',
            'photo' => 'mimes:jpg,jpeg,png,svg|image'
        ]);

        $input = $request->input();

        if ($request->hasFile('photo')) {
            $getPhoto = User::select('photo')->where('username', $username)->first();
            if ($getPhoto != null) {
                $delete = Storage::delete($getPhoto->photo);
            }
            $photo = $request->file('photo')->store('images/profile');
        } else {
            $photo = null;
        }

        if ($request->has('password')) {
            $input['password'] = Hash::make($input['password']);
        }

        if ($request->has('github')) {
            $input['github'] = 'github.com/' . $input['github'];
        }

        if ($request->has('twitter')) {
            $input['twitter'] = 'twitter.com/' . $input['twitter'];
        }

        $input['photo'] = $photo;
        $update = User::where('username', $username)->first()->update($input);

        return [
            'code' => 200,
            'message' => 'Updated succesfully',
        ];
    }
}
