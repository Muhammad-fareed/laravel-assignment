<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->transform(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
        ];
    }

    /**
     * Customize the response for the resource collection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function toResponse($request)
    // {
    //     return parent::toResponse($request)->with([
    //         'meta' => [
    //             'total' => $this->total(),
    //             'count' => $this->count(),
    //             'per_page' => $this->perPage(),
    //             'current_page' => $this->currentPage(),
    //             'total_pages' => $this->lastPage(),
    //         ],
    //     ]);
    // }
}
