<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->resource->id,
            'title'       => $this->resource->title,
            'description' => $this->resource->description,
            'tags'        => TagResource::collection($this->whenLoaded('tags')),
            'like_counts' => $this->when(isset($this->resource->likes_count), $this->resource->likes_count),
            'created_at'  => $this->resource->created_at,
        ];
    }
}
