<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'final_score' => $this->final_score,
            'created_at' => $this->created_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'term' => new TermResource($this->whenLoaded('term')),
        ];
    }
}
