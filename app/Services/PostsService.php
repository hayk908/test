<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\JsonResponse;

class PostsService
{
    /**
     *
     * @param array<string, mixed> $data
     * @param int $userId
     * @return Builder|Model
     */
    public function createPost(array $data, int $userId): Builder|Model
    {
        $postsData = [
            'user_id' => $userId,
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        return Post::query()->create($postsData);
    }

    /**
     *
     * @param int $userId
     * @return array<string, mixed>
     */
    public function getPost(int $userId): array
    {
        $user = User::query()->find($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userPost = Post::query()->where('user_id', $userId)
            ->where('active', true)
            ->get();

        $count = $userPost->count();

        return [
            'userName' => $user['name'],
            'posts' => $userPost,
            'count' => $count
        ];
    }
}