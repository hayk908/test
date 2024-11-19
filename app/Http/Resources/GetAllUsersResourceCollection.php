<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAllUsersResourceCollection extends ResourceCollection
{

    /**
     * Преобразует коллекцию в массив.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'count' => $this->collection->count(),
        ];
    }
}
