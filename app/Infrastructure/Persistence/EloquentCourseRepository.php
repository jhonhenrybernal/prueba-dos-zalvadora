<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function all(): Collection
    {
        return Course::all();
    }

    public function find(int $id): Course
    {
        return Course::findOrFail($id);
    }

    public function save(array $data): Course
    {
        return Course::create($data); // <-- AHORA sí espera array
    }

    public function update(int $id, array $data): Course
    {
        $course = $this->find($id);
        $course->update($data);
        return $course;
    }

    public function delete(int $id): void
    {
        Course::destroy($id);
    }

    public function withStudents(): Collection
    {
        return Course::with('students')->get();
    }
}
