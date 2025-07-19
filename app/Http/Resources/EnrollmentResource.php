<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'student_id'  => $this->student_id,
            'course_id'   => $this->course_id,
            'enrolled_at' => $this->enrolled_at->toDateTimeString(),
        ];
    }
}
