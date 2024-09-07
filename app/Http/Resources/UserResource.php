<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "position_id" => $this->position_id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "photo" => $this->photo,
            "position" => new PositionResource($this->position),
        ];
    }
}
