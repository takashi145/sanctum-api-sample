<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request) {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function login(LoginUserRequest $request) {
        
        if(Auth::attempt($request->only(['email', 'password']))) {
            $token = $request->user()->createToken('token-name')->plainTextToken;

            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json([
                'jwt' => $token,
            ], Response::HTTP_OK)->withCookie($cookie);
        }

        return response()->json([
            'message' => 'ログイン失敗'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout() {
        $cookie = Cookie::forget('jwt');
        return response()->noContent()->withCookie($cookie);
    }

}
