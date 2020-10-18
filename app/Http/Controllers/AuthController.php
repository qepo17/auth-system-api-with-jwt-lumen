<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login()
    {
        $username = request('username');
        $password = request('password');

        $userData = User::select('username', 'password')->firstWhere('username', $username);
        if ($userData && Hash::check($password, $userData['password'])) {
            $payload = [
                'iat' => time(), // Time when JWT was issued.
                'exp' => time() + 60 * 60, // Expiration time (1 hour)
                'username' => $username,
            ];

            $jwt = JWT::encode($payload, env('APP_KEY'));

            $payload['exp'] = time() + ((60 * 60) * 24) * 15; // 15 days
            $refresh = JWT::encode($payload, env('APP_KEY'));

            return ['code' => 200, 'message' => 'Login succeed', 'access_token' => $jwt, 'refresh_token' => $refresh];
        } else {
            return ['code' => 400, 'message' => 'Wrong username or password'];
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username|min:5|max:25',
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'photo' => 'mimes:jpg,jpeg,png,svg|image'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('images/profile');
        } else {
            $photo = null;
        }

        $input = $request->input();
        $hashPassword = Hash::make($input['password']);
        $input['password'] = $hashPassword;
        $input['photo'] = $photo;

        $post = User::create($input);

        return [
            'code' => 200,
            'message' => 'Register success',
        ];
    }
}
