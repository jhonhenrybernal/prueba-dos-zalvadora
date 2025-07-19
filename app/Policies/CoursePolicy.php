<?php
namespace App\Policies;

use App\Models\User;
use App\Domain\Course\Models\Course;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true; 
    }

    public function view(User $user, Course $course): bool
    {
        return $user->is_admin || $user->id === $course->owner_id;
    }

    public function create(User $user): bool
    {
       return $user->is_admin;
    }

    public function update(User $user, Course $course): bool
    {
        return $user->is_admin || $user->id === $course->owner_id;

    }

    public function delete(User $user, Course $course): bool
    {
        return $user->is_admin || $user->id === $course->owner_id;

    }
}
