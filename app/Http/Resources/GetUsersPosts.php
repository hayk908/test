<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property string $userName
 * @property array $posts
 * @property int $count
 */
class GetUsersPosts extends JsonResource
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
            'userName' => $this->resource['userName'],
            'posts' => $this->resource['posts'],
            'count' => $this->resource['count'],
        ];
    }
}