<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user'  => UserResource::make($this->resource),
            'token' => $this->resource->createToken('authToken')->plainTextToken,
        ];
    }
}
