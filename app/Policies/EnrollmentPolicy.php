<?php

namespace App\Policies;

use App\Models\User;
use App\Domain\Enrollment\Models\Enrollment;

class EnrollmentPolicy
{
    public function create(User $user): bool
    {
        return $user->is_admin;
    }
}
