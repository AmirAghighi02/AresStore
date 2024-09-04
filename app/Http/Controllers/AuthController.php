<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'data' => ['token' => $token],
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 403);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->except('password_confirmation');
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $data = new RegisterResource($user);

        return response()->json($data, 201);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        session()->invalidate();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function passwordReset(PasswordResetRequest $request) {}
}
