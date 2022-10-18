<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            $token = $request->user()->createToken('token-name');

            return response()->json([
                'token' => $token->plainTextToken,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'ログイン失敗'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

}
