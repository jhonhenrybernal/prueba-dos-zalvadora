<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Enrollment\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inscribe estudiantes aleatoriamente en cursos
        Enrollment::factory()->count(30)->create();
    }
}

