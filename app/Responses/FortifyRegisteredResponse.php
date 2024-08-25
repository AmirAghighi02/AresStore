<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Symfony\Component\HttpFoundation\Response;

class FortifyRegisteredResponse implements RegisterResponse
{
    public static function build(): self
    {
        return new self;
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json([
            'message' => 'Your account has been created.',
            'email' => $request->email,
        ], 201);
    }
}
