<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\Profile;

/**
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string|null $bio
 * @property-read string|null $avatar
 */
class GetProfileByIdResources extends JsonResource
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
            'bio' => $this->bio,
            'avatar' => $this->avatar,
        ];
    }
}