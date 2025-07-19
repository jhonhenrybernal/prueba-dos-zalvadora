<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Course\Repositories\CourseRepositoryInterface;
use App\Infrastructure\Persistence\EloquentCourseRepository;
use App\Domain\Student\Repositories\StudentRepositoryInterface;
use App\Infrastructure\Persistence\EloquentStudentRepository;
use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;
use App\Infrastructure\Persistence\EloquentEnrollmentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            EloquentCourseRepository::class
        );
        $this->app->bind(
            StudentRepositoryInterface::class,
            EloquentStudentRepository::class
        );
        $this->app->bind(
            EnrollmentRepositoryInterface::class,
            EloquentEnrollmentRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
