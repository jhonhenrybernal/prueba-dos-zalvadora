<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Course\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 10 cursos de prueba
        Course::factory()->count(10)->create();
    }
}