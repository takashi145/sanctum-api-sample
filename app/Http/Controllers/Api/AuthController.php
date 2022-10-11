<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $token = $request->user()->createToken('token-name');
            return response()->json([
                'token' => $token->plainTextToken,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'ログイン失敗'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
