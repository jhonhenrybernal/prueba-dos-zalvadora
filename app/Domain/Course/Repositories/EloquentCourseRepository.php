<?php
namespace App\Infrastructure\Course\Repositories;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::store('redis')->remember('courses.all', 60, function () {
            return Course::all();
        });
    }

    public function find(int $id): Course
    {
        return Cache::store('redis')->remember("courses.{$id}", 60, function () use ($id) {
            return Course::findOrFail($id);
        });
    }

    public function save(array $data): Course
    {
        $course = Course::create($data);
        Cache::store('redis')->forget('courses.all');
        return $course;
    }

    public function update(int $id, array $data): Course
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        Cache::store('redis')->forget("courses.{$id}");
        Cache::store('redis')->forget('courses.all');
        return $course;
    }

    public function delete(int $id): void
    {
        $course = Course::findOrFail($id);
        $course->delete();
        Cache::store('redis')->forget("courses.{$id}");
        Cache::store('redis')->forget('courses.all');
    }

    public function withStudents(): Collection
    {
        return Cache::store('redis')->remember('courses.with_students', 60, function () {
            return Course::with('students')->get();
        });
    }
}
