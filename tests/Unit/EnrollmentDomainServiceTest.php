<?php

use App\Domain\Enrollment\Services\EnrollmentDomainService;
use App\Domain\Enrollment\Repositories\EnrollmentRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use Carbon\Carbon;
use App\Domain\Enrollment\Models\Enrollment;
use DomainException;

it('throws exception on duplicate enrollment', function () {
    $repo = Mockery::mock(EnrollmentRepositoryInterface::class, function (MockInterface $m) {
        $m->shouldReceive('exists')->with(1, 1)->once()->andReturnTrue();
    });
    $service = new EnrollmentDomainService($repo);
    expect(fn() => $service->enroll(1, 1))->toThrow(DomainException::class);
});

it('enrolls successfully when no duplicate', function () {
    $repo = Mockery::mock(EnrollmentRepositoryInterface::class, function (MockInterface $m) {
        $m->shouldReceive('exists')->with(1, 1)->once()->andReturnFalse();
        $m->shouldReceive('create')
            ->withArgs(fn($arg) =>
                $arg['student_id'] === 1 &&
                $arg['course_id'] === 1 &&
                $arg['enrolled_at'] instanceof Carbon
            )
            ->once()
            ->andReturn(Enrollment::make([
    'student_id' => 1,
    'course_id' => 1,
    'enrolled_at' => new Carbon(),
]));
    });
    $service = new EnrollmentDomainService($repo);
    $result  = $service->enroll(1, 1);
    expect($result->student_id)->toBe(1);
});

afterEach(fn() => Mockery::close());