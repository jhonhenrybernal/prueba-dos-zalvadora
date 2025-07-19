<?php
namespace App\Domain\Student\Services;

use App\Domain\Student\Repositories\StudentRepositoryInterface;
use App\Domain\Student\Models\Student;
use Illuminate\Validation\ValidationException;

class StudentDomainService
{
    private StudentRepositoryInterface $repository;

    public function __construct(StudentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Crea un estudiante, validando unicidad de email
     *
     * @throws ValidationException
     */
    public function createStudent(array $data): Student
    {
        if ($this->repository->existsByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['El email ya está en uso.'],
            ]);
        }
        return $this->repository->create($data);
    }

    /**
     * Actualiza un estudiante, controlando cambios de email
     *
     * @throws ValidationException
     */
    public function updateStudent(int $id, array $data): Student
    {
        $student = $this->repository->find($id);
        if (! $student) {
            throw ValidationException::withMessages([
                'student' => ['Estudiante no encontrado.'],
            ]);
        }
        if (isset($data['email'])
            && $data['email'] !== $student->email
            && $this->repository->existsByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['El email ya está en uso.'],
            ]);
        }
        return $this->repository->update($id, $data);
    }

    /**
     * Elimina un estudiante
     *
     * @throws ValidationException
     */
    public function deleteStudent(int $id): void
    {
        $student = $this->repository->find($id);
        if (! $student) {
            throw ValidationException::withMessages([
                'student' => ['Estudiante no encontrado.'],
            ]);
        }
        $this->repository->delete($id);
    }
}