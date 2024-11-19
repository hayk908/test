<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUsersRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserDateList;
use App\Http\Resources\GetAllUsersResourceCollection;
use App\Http\Resources\UserCreateResource;
use App\Http\Resources\GetUsersResource;
use App\Http\Resources\GetDataResource;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function create(UserRequest $userRequest): UserCreateResource
    {
        $validatedData = $userRequest->validated();

        $user = $this->userService->createUser($validatedData);

        return new UserCreateResource($user);
    }

    public function update(UserUpdateRequest $userUpdateRequest): JsonResponse
    {
        $this->userService->updateUser($userUpdateRequest->validated());

        return response()->json(['message' => 'Пользователь обновлен успешно']);
    }

    public function delete(UserDeleteRequest $userDeleteRequest): JsonResponse
    {
        $validated = $userDeleteRequest->validated();

        $ids = array_values($validated);

        $message = $this->userService->deleteUser($ids);

        return response()->json($message);
    }

    public function enableUser(User $user, Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $message = $this->userService->enableUser($user->id, $validatedData);

        return response()->json($message);
    }

    /**
     * @throws Exception
     */
    public function getAllUsers(GetUsersRequest $getUsersRequest): GetAllUsersResourceCollection
    {
        $users = $this->userService->getAllUsers($getUsersRequest);

        return new GetAllUsersResourceCollection($users);
    }

    public function getData(UserDateList $userDateList): AnonymousResourceCollection
    {
        $validatedData = $userDateList->validated();

        $users = $this->userService->getData($validatedData);

        return GetDataResource::collection($users);
    }
}
