<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestName;
use App\Http\Resources\CreateCategoryResource;
use App\Services\CategoryService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function createCategory(FormRequestName $requestName, User $user): CreateCategoryResource
    {
        $data = $requestName->toArray();
        $category = $this->categoryService->createCategory($data, $user);

        return new CreateCategoryResource($category);
    }

    public function getCategory(int $userId): JsonResponse
    {
        $categoriesData = $this->categoryService->getCategoriesByUser($userId);

        return response()->json($categoriesData);
    }
}
