<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'agent'=>new UserResource($this->agent),
            'user'=>new UserResource($this->user),
            'title'=>$this->description,
            'status'=>$this->status,
            'type'=>$this->type,
            'duration'=>$this->duration,
            'started_at'=>$this->started_at,
            'ended_at'=>$this->ended_at,
            'rating'=>new RatingResource($this->rating),
        ];
    }
}
