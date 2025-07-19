<?php

namespace App\Application\Course\Handlers;

use App\Application\Course\Commands\CreateCourseCommand;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepositoryInterface;

class CreateCourseHandler
{
    private CourseRepositoryInterface $repository;

    public function __construct(CourseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateCourseCommand $command): Course
    {
        $course = new Course([
            'title' => $command->title(),
            'description' => $command->description(),
            'start_date' => $command->startDate(),
            'end_date' => $command->endDate(),
        ]);

        return $this->repository->save($course);
    }
}