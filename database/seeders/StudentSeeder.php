<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Student\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 20 estudiantes de prueba
        Student::factory()->count(20)->create();
    }
}