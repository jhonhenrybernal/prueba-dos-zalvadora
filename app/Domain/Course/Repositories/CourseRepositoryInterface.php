<?php
namespace App\Domain\Course\Repositories;

use App\Domain\Course\Models\Course;
use Illuminate\Support\Collection;

interface CourseRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): Course;
    public function save(array $data): Course;           
    public function update(int $id, array $data): Course;
    public function delete(int $id): void;
    public function withStudents(): Collection;
}
