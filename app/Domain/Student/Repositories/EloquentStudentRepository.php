<?php
namespace App\Infrastructure\Student\Repositories;

use App\Domain\Student\Models\Student;
use App\Domain\Student\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class EloquentStudentRepository implements StudentRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::store('redis')->remember('students.all', 60, function () {
            return Student::all();
        });
    }

    public function find(int $id): Student
    {
        return Cache::store('redis')->remember("students.{$id}", 60, function () use ($id) {
            return Student::findOrFail($id);
        });
    }

    public function create(array $data): Student
    {
        $student = Student::create($data);
        Cache::store('redis')->forget('students.all');
        return $student;
    }

    public function update(int $id, array $data): Student
    {
        $student = Student::findOrFail($id);
        $student->update($data);
        Cache::store('redis')->forget("students.{$id}");
        Cache::store('redis')->forget('students.all');
        return $student;
    }

    public function delete(int $id): void
    {
        $student = Student::findOrFail($id);
        $student->delete();
        Cache::store('redis')->forget("students.{$id}");
        Cache::store('redis')->forget('students.all');
    }

    public function withCourses(): Collection
    {
        return Cache::store('redis')->remember('students.with_courses', 60, function () {
            return Student::with('courses')->get();
        });
    }
}
