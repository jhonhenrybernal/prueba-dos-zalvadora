<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Lanza los seeders en orden
        $this->call([
            CourseSeeder::class,
            StudentSeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}