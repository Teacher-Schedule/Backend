<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    private function averageGrade($grades): int
    {
        if ($grades->isEmpty()) {
            return 0;
        }

        $average = $grades->avg('grade');

        return (int) round($average);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "group_id" => $this->group_id,
            "grades" => $this->grades,
            "average_grade" => $this->averageGrade($this->grades),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
