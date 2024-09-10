<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            return ResponseConverter::convert(
                ResponseUtil::builder()
                    ->setMessage('auth.login.success')
                    ->setAction(__FUNCTION__)
            );
        }

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('auth.login.fail')
                ->setAction(__FUNCTION__)
                ->setStatusCode(Response::HTTP_FORBIDDEN)
        );
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->except('password_confirmation');
        $user = User::create($validated)->assignRole(Roles::COSTUMER);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('auth.register.success')
                ->setAction(__FUNCTION__)
                ->setData(new RegisterResource($user))
                ->setStatusCode(Response::HTTP_CREATED)
        );
    }

    public function logout(): JsonResponse
    {
        session()->invalidate();

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('auth.logout.success')
                ->setAction(__FUNCTION__)
        );
    }

    public function passwordReset(PasswordResetRequest $request) {}
}
