<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Student\Models\Student;
use App\Domain\Student\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentStudentRepository implements StudentRepositoryInterface
{
    /**
     * Obtener todos los estudiantes
     */
    public function all(): Collection
    {
        return Student::all();
    }

    /**
     * Encontrar un estudiante o fallar
     */
    public function find(int $id): Student
    {
        return Student::findOrFail($id);
    }

    /**
     * Crear un nuevo estudiante
     */
    public function create(array $data): Student
    {
        return Student::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
        ]);
    }

    /**
     * Actualizar un estudiante existente
     */
    public function update(int $id, array $data): Student
    {
        $student = Student::findOrFail($id);
        $student->fill([
            'first_name' => $data['first_name'] ?? $student->first_name,
            'last_name'  => $data['last_name']  ?? $student->last_name,
            'email'      => $data['email']      ?? $student->email,
        ]);
        $student->save();

        return $student;
    }

    /**
     * Verifica si ya existe un estudiante con este email
     */
    public function existsByEmail(string $email): bool
    {
        return Student::where('email', $email)->exists();
    }

    /**
     * Elimina un estudiante por su ID
     */
    public function delete(int $id): void
    {
        Student::destroy($id);
    }

    public function withCourses(): Collection
    {
        return Student::with('courses')->get();
    }
}
