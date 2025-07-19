<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Enrollment\Models\Enrollment;
use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;

class EloquentEnrollmentRepository implements EnrollmentRepositoryInterface
{
    /**
     * Verifica si ya existe la inscripción
     */
    public function exists(int $studentId, int $courseId): bool
    {
        return Enrollment::where('student_id', $studentId)
                         ->where('course_id', $courseId)
                         ->exists();
    }

    /**
     * Crea una nueva inscripción
     *
     * @param  array  $data
     * @return Enrollment
     */
    public function create(array $data): Enrollment
    {
        return Enrollment::create([
            'student_id'  => $data['student_id'],
            'course_id'   => $data['course_id'],
            'enrolled_at' => $data['enrolled_at'] ?? now(),
        ]);
    }

    /**
     * Obtiene una inscripción específica (o null si no existe)
     */
    public function getByStudentAndCourse(int $studentId, int $courseId): ?Enrollment
    {
        return Enrollment::where('student_id', $studentId)
                         ->where('course_id', $courseId)
                         ->first();
    }
}
