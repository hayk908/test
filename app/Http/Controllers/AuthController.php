<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Service\Auth\Action\ParentAuthAction;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AuthController extends Controller
{
    public function login(
        LoginRequest     $authsRequestName,
        ParentAuthAction $parentAuthAction
    ): JsonResponse
    {
        $data = $authsRequestName->all();

        $user = User::query()->where('email', $data['email'])->first();

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new ValidationException("Wrong password");
        }

        return response()->json($parentAuthAction->run($data));
    }
}
