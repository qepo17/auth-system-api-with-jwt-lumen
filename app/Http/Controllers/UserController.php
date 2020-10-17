<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
    }
    public function show($id)
    {
        return User::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'unique:users,username|min:5|max:25',
            'name' => 'string',
            'email' => 'unique:users,email|email',
            'password' => 'min:8',
            'photo' => 'mimes:jpg,jpeg,png,svg|image'
        ]);

        $input = $request->input();

        if ($request->has('password')) {
            $input['password'] = Hash::make($input['password']);
        }

        if ($request->has('github')) {
            $input['github'] = 'github.com/' . $input['github'];
        }

        if ($request->has('twitter')) {
            $input['twitter'] = 'twitter.com/' . $input['twitter'];
        }

        $update = User::find($id)->update($input);

        return [
            'code' => 200,
            'message' => 'Updated succesfully',
        ];
    }
}
