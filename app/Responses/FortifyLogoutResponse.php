<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Symfony\Component\HttpFoundation\Response;

class FortifyLogoutResponse implements LogoutResponse
{
    public static function build(): self
    {
        return new self;
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json([
            'message' => 'You have been logged out.',
        ]);
    }
}
