<?php

namespace App\Services;

use App\Http\Requests\GetUsersRequest;
use App\Models\User;
use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

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
            throw new InvalidArgumentException('Этот email уже занят.');
        }

        if (!is_string($data['password'])) {
            throw new InvalidArgumentException('Password должен быть строкой.');
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
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $user->update(['name' => $data['name']]);
    }


    /**
     * @param array<int|mixed> $data
     * @return array<string, string>
     */
    public function deleteUser(array $data): array
    {
        $ids = array_map(
            static function ($id) {
                if (!is_numeric($id)) {
                    throw new \InvalidArgumentException('The id must be an integer.');
                }
                return (int)$id;
            },
            $data
        );

        foreach ($ids as $id) {
            $user = User::find($id);

            if (!$user || Auth::id() !== $id) {
                throw new NotFoundHttpException("ID does not match");
            }

            $user->delete();
        }

        return ['message' => 'User deleted successfully'];
    }

    /**
     * @param int $id
     * @param array<string, string> $data
     * @return array<string, string>
     */
    public function enableUser(int $id, array $data): array
    {
        $user = User::find($id);

        if (!$user) {
            throw new NotFoundHttpException("Пользователь не найден");
        }

        $user->update(['name' => $data['name']]);

        return ['message' => 'Пользователь обновлен успешно'];
    }

    /**
     * @param GetUsersRequest $request
     * @return Collection<int, User>
     * @throws Exception
     */
    public function getAllUsers(GetUsersRequest $request): Collection
    {

        $authUser = Auth::user();

        if (!$authUser || $authUser->role !== UserRoleEnum::ADMIN->value) {
            throw new Exception('Вы не администратор');
        }

        $data = $request->toArray();

        if (isset($request->order)) {
            if (!in_array($request->order, ['asc', 'desc'], true)) {
            $request->order = 'asc';
            }
            return User::query()->orderBy('id', $request->order)->get();
        }

        if (isset($data['users']) && is_array($data['users'])) {
            return User::query()->whereIn('id', $data['users'])->get();
        }

        $query = User::query();

        $enable = $request->input('enable');
        if ($enable === '0' || $enable === 0) {
            return $query->where('enable', 0)->get();
        }

        if (!is_null($enable)) {
            $query->where('enable', $enable);
        }

        return $query->get();
    }

    /**
     * @param array<string, mixed> $data
     * @return Collection<int, User>
     */
    public function getData(array $data): Collection
    {
        return User::query()->whereBetween('created_at', [$data['start'], $data['end']])->get();
    }
}
