<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService
{
    /**
     * Создать категорию и прикрепить её к пользователю.
     *
     * @param array<string, mixed> $data
     * @param User $user
     * @return Category
     */
    public function createCategory(array $data, User $user): Category
    {
        return DB::transaction(function () use ($data, $user) {
            $category = Category::query()->create($data);
            $user->category()->attach($category->id);

            return $category;
        });
    }

    /**
     * Получить категории пользователя.
     *
     * @param int $userId
     * @return array<string, mixed>
     */
    public function getCategoriesByUser(int $userId): array
    {
        $user = User::find($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return [
            'userName' => $user->name,
            'categories' => $user->category,
        ];
    }
}