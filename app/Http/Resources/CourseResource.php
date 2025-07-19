<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CourseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'start_date' => Carbon::now()->toDateString(),
            'end_date'   => Carbon::now()->addDay()->toDateString(),
            'students'    => StudentResource::collection($this->whenLoaded('students')),
        ];
    }
}
