<?php

namespace App\Service;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    /**
     * @param array<string, mixed> $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $userExists = User::query()->where('email', $data['email'])->exists();

        if ($userExists) {
            throw new ValidationException('Этот email уже занят.');
        }

        if (!is_string($data['password'])) {
            throw new \InvalidArgumentException('Password должен быть строкой');
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function updateUser(array $data): void
    {
        $updateUser = User::query()->where('email', $data['email'])->first();

        if ($updateUser) {
            User::query()->where('email', $data['email'])->update(['name' => $data['name']]);
        } else {
            throw new NotFoundHttpException("Пользователь не найден");
        }
    }

    /**
     * @param array<int> $data
     * @return array<string, string>
     */
    public function deleteUser(array $data): array
    {
        $user = Auth::user();

        foreach ($data as $item) {
            if (!$user || $user->id !== (int)$item) {
                throw new NotFoundHttpException("ID не соответствует");
            }

            User::query()->where('id', $item)->delete();
        }

        return ['message' => 'Пользователь удален успешно'];
    }

    /**
     * @param string $order
     * @return array<User>
     */
    public function getUsers(string $order): array
    {
        $users = User::query()->orderBy('id', $order)->get()->all();

        return $users;
    }

    /**
     * @param int $id
     * @param array<string, mixed> $data
     * @return array<string, string>
     */
    public function enableUser(int $id, array $data): array
    {
        User::query()->where('id', $id)->update(['name' => $data['name']]);

        return [
            'message' => 'Пользователь с id ' . $id . ' обновлен'
        ];
    }

    /**
     * @param Request $request
     * @return array<string, mixed>
     * @throws Exception
     */
    public function getAllUsers(Request $request): array
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            throw new Exception('Вы не администратор');
        }

        $users = [];

        $enable = $request->query('enable');

        $data = $request->toArray();

        if ($enable !== null) {
            $request->validate(['enable' => 'in:0,1|required']);
            $users = User::query()->where('enable', $enable)->get()->all();
        } elseif (isset($data['users']) && is_array($data['users'])) {
            foreach ($data['users'] as $userId) {
                $foundUser = User::query()->where('id', $userId)->first();
                if ($foundUser) {
                    $users[] = $foundUser;
                }
            }
        } else {
            $users = User::all();
        }

        return ['users' => $users, 'count' => count($users)];
    }

    /**
     * @param array<string, string> $data
     * @return array<string, array<int, array<string, string>>>
     */
    public function getData(array $data): array
    {
        $dataUser = User::query()->whereBetween('created_at', [$data['start'], $data['end']])->get();

        $users = [];
        foreach ($dataUser as $item) {
            $users[] = [
                'name' => is_scalar($item['name']) ? (string)$item['name'] : '',
                'email' => is_scalar($item['email']) ? (string)$item['email'] : '',
            ];
        }

        return ['users' => $users];
    }

}
