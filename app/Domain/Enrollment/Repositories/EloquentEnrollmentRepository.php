<?php
namespace App\Infrastructure\Enrollment\Repositories;

use App\Domain\Enrollment\Models\Enrollment;
use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class EloquentEnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function exists(int $studentId, int $courseId): bool
    {
        // Podrías cachear si lo usas mucho, pero ojo con duplicados.
        $key = "enrollment.exists.{$studentId}.{$courseId}";
        return Cache::store('redis')->remember($key, 30, function () use ($studentId, $courseId) {
            return Enrollment::where('student_id', $studentId)
                ->where('course_id', $courseId)
                ->exists();
        });
    }

    public function create(array $data): Enrollment
    {
        $enrollment = Enrollment::create($data);
        // Limpia cualquier cache relacionado con este curso o estudiante
        Cache::store('redis')->forget("enrollment.exists.{$data['student_id']}.{$data['course_id']}");
        // Si tienes listados, invalidalos aquí
        return $enrollment;
    }

    public function getByStudentAndCourse(int $studentId, int $courseId): ?Enrollment
    {
        $key = "enrollment.{$studentId}.{$courseId}";
        return Cache::store('redis')->remember($key, 30, function () use ($studentId, $courseId) {
            return Enrollment::where('student_id', $studentId)
                ->where('course_id', $courseId)
                ->first();
        });
    }
}
