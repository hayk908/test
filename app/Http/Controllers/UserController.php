<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUsersRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserDateList;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function create(UserRequest $userRequestName): JsonResponse
    {
        $validatedData = $userRequestName->validated();

        $user = $this->userService->createUser($validatedData);

        return response()->json($user, 201);
    }

    public function update(UserUpdateRequest $userUpdateRequest): JsonResponse
    {
        $data = $userUpdateRequest->toArray();

        $this->userService->updateUser($data);

        return response()->json([
            'message' => 'Пользователь обновлен успешно'
        ]);
    }

    public function delete(UserDeleteRequest $userDeleteRequest): JsonResponse
    {
        $validatedData = $userDeleteRequest->validated();

        $data = [];

        foreach ($validatedData as $item) {
            if (is_numeric($item)) {
                $data[] = (int)$item;
            } else {
                throw new \InvalidArgumentException('Ожидается числовое значение для идентификатора пользователя.');
            }
        }

        $message = $this->userService->deleteUser($data);

        return response()->json($message);
    }

    public function get(Request $request): JsonResponse
    {
        $order = $request->query('order', 'asc');

        if (!is_string($order)) {
            $order = 'asc';
        }

        $user = $this->userService->getUsers($order);

        return response()->json($user);
    }

    public function enableUser(User $user, Request $request): JsonResponse
    {
        $data = $request->validate(['name' => 'required|string|max:255']);

        $message = $this->userService->enableUser($user->id, $data);

        return response()->json($message);
    }

    /**
     * @throws Exception
     */
    public function getAllUsers(GetUsersRequest $request): JsonResponse
    {
        $users = $this->userService->getAllUsers($request);

        return response()->json($users);
    }

    public function getData(UserDateList $userDateList): JsonResponse
    {
        $validatedData = $userDateList->validated();

        $data = [];

        foreach ($validatedData as $key => $value) {

            $data[$key] = is_scalar($value) ? (string)$value : '';
        }

        $users = $this->userService->getData($data);

        return response()->json($users);
    }
}
