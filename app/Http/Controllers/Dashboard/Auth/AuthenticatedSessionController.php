<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $admin = $request->authenticate();

        $token = $admin->createToken('auth_token')->plainTextToken;

        return $this->respond([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Display the current admin.
     */
    public function show(Request $request): JsonResponse
    {
        return $this->respond($request->user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respond(message: 'Logged out successfully.');
    }
}
