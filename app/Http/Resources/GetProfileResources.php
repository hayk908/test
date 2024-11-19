<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

/**
 * @property User $user
 * @property Profile $profile
 */
class GetProfileResources extends JsonResource
{
    /**
     *
     * @param Request $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        return [
            'user' => $this->resource['user'],
            'profile' => $this->resource['profile'],
        ];
    }
}