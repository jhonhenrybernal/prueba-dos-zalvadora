<?php

namespace Database\Factories;

use App\Domain\Course\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date'  => $this->faker->date(),
            'end_date'    => $this->faker->date("Y-m-d", '+1 month'),
            'owner_id' => User::factory(),
        ];
    }
}