<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Course\Models\Course;
use App\Policies\CoursePolicy;
use App\Domain\Student\Models\Student;
use App\Policies\StudentPolicy;
use App\Domain\Enrollment\Models\Enrollment;
use App\Policies\EnrollmentPolicy;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Course::class     => CoursePolicy::class,
        Student::class    => StudentPolicy::class,
        Enrollment::class => EnrollmentPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         
    }
}
