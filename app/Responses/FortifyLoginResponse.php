<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;
use Symfony\Component\HttpFoundation\Response;

class FortifyLoginResponse implements LoginResponse
{
    public static function build(): self
    {
        return new self;
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json([
            'message' => 'You are Logged In Successfully',
            'date' => [
                'token' => Auth::user()?->createToken(Auth::user()->name)->plainTextToken,
            ],
        ]);
    }
}
