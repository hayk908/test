<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostsController extends Controller
{
    public function createPost(Request $request, $userId): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'string|nullable',
        ]);

        $data = $request->toArray();

        $postsData = [
            'user_id' => $userId,
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        $createPost = Post::query()->create($postsData);

        return response()->json([$createPost]);
    }

    public function getPost($userId): JsonResponse
    {
        $user = User::query()->find($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userPost = Post::query()->where('user_id', $userId)
            ->where('active', true)->get();

        $count = Post::query()->where('user_id', $userId)->where('active', true)->count();
        return response()->json([
            'userName' => $user->name,
            'posts' => $userPost,
            'count' => $count
        ]);
    }
}
