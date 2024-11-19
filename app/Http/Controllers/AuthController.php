<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function login(LoginRequest $authsRequestName): JsonResponse
    {
        $response = $this->authService->login($authsRequestName);

        return response()->json($response);
    }
}
