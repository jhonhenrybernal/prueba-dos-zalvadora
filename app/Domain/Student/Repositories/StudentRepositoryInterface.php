<?php
namespace App\Domain\Student\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Student\Models\Student;

interface StudentRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Student;
    public function create(array $data): Student;
    public function update(int $id, array $data): Student;
    public function delete(int $id): void;
    public function existsByEmail(string $email): bool;
    public function withCourses(): Collection;
}
