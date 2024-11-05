<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDateList;
use App\Http\Requests\UserRequestName;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function create(UserRequestName $userRequestName): JsonResponse
    {

        $data = $userRequestName->toArray();

        foreach ($data['userArray'] as $item) {
            $user = [
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make($item['password'])
            ];

            $currentUser = User::query()->create($user);
        }

        return response()->json([$currentUser]);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $updateUser = User::query()->where('email', $data['email'])->first();

        if ($updateUser) {
            User::query()->where('email',
                $data['email'])->update(['name' => $data['name']]);
        } else {
            throw new NotFoundHttpException("There is not");
        }

        return response()->json(['message' => 'User updated successfully']);
    }

    public function delete(Request $request): JsonResponse
    {
        $user = Auth::user();

        $data = $request->toArray();

        foreach ($data['delete'] as $item) {

            if ($user->id !== (int)$item) {
                throw new NotFoundHttpException("id is not suitable");
            }

            User::query()->where('id', $item)->delete();
        }

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function search(Request $request): JsonResponse
    {
        $email = $request->query('name');
        $users = User::where('name', 'LIKE', "%{$email}%")->pluck('id', 'name');
        return response()->json([$users]);
    }

    public function get(Request $request): JsonResponse
    {
        $order = $request->query('order');
        $user = User::query()->orderBy('id', $order)->get();
        return response()->json([$user]);
    }

    public function updateEnable($id, Request $request): JsonResponse
    {
        $data = $request->validate(['name' => 'required|string|max:255',]);

        $userUpdate = User::query()->where('id', $id)->update(['name' => $data['name']]);

        if (!$userUpdate) {
            throw new NotFoundHttpException('there is no such user');
        }

        return response()->json([
            'message' => 'user with id' . ' ' . $id . ' ' . 'revealed'
        ]);
    }

    public function getAllUsers(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user['role'] !== 'admin') {
            throw new Exception('You are not an admin');
        }

        $users = [];

        $enable = $request->query('enable');

        $data = $request->toArray();

        if ($enable !== null) {
            $request->validate(['enable' => 'in:0,1|required']);
            $user = User::query()->where('enable', $enable)->get();
            $users = $user;
        } elseif (isset($data['users'])) {
            foreach ($data['users'] as $userId) {
                $user = User::query()->where('id', $userId)->first();
                $users[] = $user;
            }
        } else {
            $users = User::all();
        }

        $count = count($users);

        return response()->json([
            'users' => $users,
            'count' => $count
        ]);
    }

    public function test(): JsonResponse
    {
        return response()->json([Auth::user()]);
    }

    public function getData(UserDateList $userDateList): JsonResponse
    {
        $data = $userDateList->toArray();

        $dataUser = User::query()->whereBetween('created_at', [$data['start'], $data['end']])->get();

        $users = [];
        foreach ($dataUser as $item) {
            $user = [
                'name' => $item['name'],
                'email' => $item['email'],
            ];

            $users[] = $user;
        }

        return response()->json([
            'users' => $users
        ]);
    }
}

