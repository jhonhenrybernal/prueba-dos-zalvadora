<?php

namespace App\Infrastructure\Services;

use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;
use App\Domain\Student\Repositories\StudentRepositoryInterface;
use App\Domain\Course\Repositories\CourseRepositoryInterface;
use App\Domain\Enrollment\Models\Enrollment;

class EnrollmentDomainService
{
    private EnrollmentRepositoryInterface $enrollmentRepo;
    private StudentRepositoryInterface $studentRepo;
    private CourseRepositoryInterface $courseRepo;

    public function __construct(
        EnrollmentRepositoryInterface $enrollmentRepo,
        StudentRepositoryInterface $studentRepo,
        CourseRepositoryInterface $courseRepo
    ) {
        $this->enrollmentRepo = $enrollmentRepo;
        $this->studentRepo = $studentRepo;
        $this->courseRepo = $courseRepo;
    }

    public function enroll(int $studentId, int $courseId): Enrollment
    {
        // Verificar existencia
        $this->studentRepo->find($studentId);
        $this->courseRepo->find($courseId);

        if ($this->enrollmentRepo->exists($studentId, $courseId)) {
            throw new \DomainException('Student already enrolled in this course.');
        }

        return $this->enrollmentRepo->create([
            'student_id' => $studentId,
            'course_id' => $courseId,
            'enrolled_at' => now(),
        ]);
    }
}