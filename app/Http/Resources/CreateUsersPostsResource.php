<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class CreateUsersPostsResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'content' => $this->content,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}