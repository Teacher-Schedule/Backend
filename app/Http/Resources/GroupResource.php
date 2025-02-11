<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "labs" => LabResource::collection($this->labs),
            "lab_ids" => $this->labs->pluck('id'),
            "students" => StudentResource::collection($this->students),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
