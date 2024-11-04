<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestName;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function createCategory(FormRequestName $requestName, User $user): JsonResponse
    {
        $data = $requestName->toArray();

        $category = Category::query()->create($data);

        $user->category()->attach($category->id);

        return response()->json($category->toArray());
    }

    public function getCategory($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $categories = $user->category;

        return response()->json([
            'userName' => $user->name,
            'categories' => $categories
        ]);
    }
}
