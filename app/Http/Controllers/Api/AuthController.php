<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if($validated->fails()) {
            return response()->json([
                'errors' => $validated->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = $user->createToken('token-name');

        return response()->json([
            'token' => $token->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request) {

        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if($credentials->fails()) {
            return response()->json([
                'errors' => $credentials->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        if(Auth::attempt($request->all())) {
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
