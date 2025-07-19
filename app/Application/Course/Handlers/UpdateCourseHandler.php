<?php

namespace App\Application\Course\Handlers;

use App\Application\Course\Commands\UpdateCourseCommand;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepositoryInterface;

class UpdateCourseHandler
{
    private CourseRepositoryInterface $repository;

    public function __construct(CourseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UpdateCourseCommand $command): Course
    {
        $course = $this->repository->find($command->id());
        $course->fill([
            'title' => $command->title(),
            'description' => $command->description(),
            'start_date' => $command->startDate(),
            'end_date' => $command->endDate(),
        ]);

        return $this->repository->save($course);
    }
}