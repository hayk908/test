<?php

namespace App\Services\Auth;

use App\Http\Requests\LoginRequest;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service\Auth\Action\ParentAuthAction;

class AuthService
{
    protected ParentAuthAction $parentAuthAction;

    public function __construct(ParentAuthAction $parentAuthAction)
    {
        $this->parentAuthAction = $parentAuthAction;
    }

    /**
     *
     * @param LoginRequest $authsRequestName
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function login(LoginRequest $authsRequestName): array
    {
        $data = $authsRequestName->validated();

        $user = User::query()->where('email', $data['email'])->first();

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        if (!isset($data['password']) || !is_string($data['password'])) {
            throw new ValidationException("Password must be a string");
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new ValidationException("Wrong password");
        }

        return $this->parentAuthAction->run($data);
    }
}
