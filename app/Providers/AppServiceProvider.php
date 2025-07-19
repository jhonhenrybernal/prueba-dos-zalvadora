<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Course\Repositories\CourseRepositoryInterface::class,
            \App\Infrastructure\Course\Repositories\EloquentCourseRepository::class,


            \App\Domain\Student\Repositories\StudentRepositoryInterface::class,
            \App\Infrastructure\Student\Repositories\EloquentStudentRepository::class,

            \App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface::class,
            \App\Infrastructure\Enrollment\Repositories\EloquentEnrollmentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
