<?php
namespace App\Domain\Enrollment\Repositories;

use App\Domain\Enrollment\Models\Enrollment;

interface EnrollmentRepositoryInterface
{
    /**
     * Verifica si ya existe la inscripción
     */
    public function exists(int $studentId, int $courseId): bool;

    /**
     * Crea una nueva inscripción
     *
     * @param  array  $data
     * @return Enrollment
     */
    public function create(array $data): Enrollment;

    /**
     * Obtiene una inscripción específica (o null si no existe)
     */
    public function getByStudentAndCourse(int $studentId, int $courseId): ?Enrollment;
}
