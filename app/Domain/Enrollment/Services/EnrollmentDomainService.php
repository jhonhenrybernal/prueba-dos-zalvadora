<?php
namespace App\Domain\Enrollment\Services;

use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;
use App\Domain\Enrollment\Models\Enrollment;
use Carbon\Carbon;
use DomainException;

class EnrollmentDomainService
{
    private EnrollmentRepositoryInterface $repository;

    public function __construct(EnrollmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Inscribe un estudiante en un curso
     *
     * @throws DomainException si la inscripción ya existe
     */
    public function enroll(int $studentId, int $courseId): Enrollment
    {
        if ($this->repository->exists($studentId, $courseId)) {
            throw new DomainException('El estudiante ya está inscrito en este curso.');
        }

        $data = [
            'student_id'  => $studentId,
            'course_id'   => $courseId,
            'enrolled_at' => Carbon::now(),
        ];

        return $this->repository->create($data);
    }
}
