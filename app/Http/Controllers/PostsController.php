<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequestName;
use App\Http\Resources\CreateUsersPostsResource;
use App\Http\Resources\GetUsersPosts;
use App\Services\PostsService;

class PostsController extends Controller
{
    protected PostsService $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function createPost(PostsRequestName $postsRequestName, int $userId): CreateUsersPostsResource
    {
        $data = $postsRequestName->toArray();
        $createPost = $this->postsService->createPost($data, $userId);

        return new CreateUsersPostsResource($createPost);
    }

    public function getPost(int $userId): GetUsersPosts
    {
        $postData = $this->postsService->getPost($userId);

        return new GetUsersPosts($postData);
    }
}
