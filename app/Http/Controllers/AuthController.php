<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User;
        foreach ($user->fillable as $field) {
            if ($request->has($field)) {
                $user->$field = $request->$field;
            }
        }

        $user->save();

        return response()->json(array_merge($user->toArray(), [
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ]), 200);
    }

    public function me(): JsonResponse {
        $user = Auth::user();

        return response()->json($user, 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Пользователь с такой почтой или паролем не был найден',
            ], 401);
        }

        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
        ], 200);
    }
}
