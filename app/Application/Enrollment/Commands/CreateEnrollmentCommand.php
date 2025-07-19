<?php

namespace App\Application\Enrollment\Commands;

class CreateEnrollmentCommand
{
    private int $studentId;
    private int $courseId;

    public function __construct(int $studentId, int $courseId)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
    }

    public function studentId(): int
    {
        return $this->studentId;
    }

    public function courseId(): int
    {
        return $this->courseId;
    }
}
