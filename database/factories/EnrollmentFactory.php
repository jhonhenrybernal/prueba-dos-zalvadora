<?php
namespace Database\Factories;

use App\Domain\Enrollment\Models\Enrollment;
use App\Domain\Student\Models\Student;
use App\Domain\Course\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'student_id'  => Student::factory(),
            'course_id'   => Course::factory(),
            'enrolled_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
