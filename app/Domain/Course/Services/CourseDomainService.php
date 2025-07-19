<?php
namespace App\Domain\Course\Services;

use App\Domain\Course\Repositories\CourseRepositoryInterface;
use App\Domain\Course\Models\Course;
use Illuminate\Support\Collection;

class CourseDomainService
{
    private CourseRepositoryInterface $repository;

    public function __construct(CourseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Obtener todos los cursos
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Crear un nuevo curso con reglas de negocio adicionales
     */
    public function create(array $data): Course
    {
        // Aquí podrías añadir lógica de dominio extra
        return $this->repository->save(new Course($data));
    }

    /**
     * Actualizar un curso existente
     */
    public function update(int $id, array $data): Course
    {
        $course = $this->repository->find($id);
        if (! $course) {
            throw new \DomainException("Curso con ID {$id} no encontrado");
        }
        $course->fill($data);
        return $this->repository->save($course);
    }

    /**
     * Eliminar un curso
     */
    public function delete(int $id): void
    {
        if (! $this->repository->find($id)) {
            throw new \DomainException("Curso con ID {$id} no encontrado");
        }
        $this->repository->delete($id);
    }
}