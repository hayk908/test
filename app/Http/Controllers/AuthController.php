<?php

namespace App\Http\Controllers;

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
        Request          $request,
        ParentAuthAction $parentAuthAction
    ): array
    {
        $data = $request->all();

        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        $user = User::query()->where('email', $data['email'])->first();

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new ValidationException("Wrong password");
        }

        return $parentAuthAction->run($data);
    }
}
