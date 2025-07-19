<?php

use App\Domain\Course\Models\Course;
use App\Domain\Student\Models\Student;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => true]);
    Sanctum::actingAs($this->user);
});

it('Puede inscribir a un estudiante en un curso', function () {
    $student = Student::factory()->create();
    $course  = Course::factory()->create();
    $payload = ['student_id' => $student->id, 'course_id' => $course->id];
    postJson('/api/v1/enrollments', $payload)
        ->assertCreated()
        ->assertJsonPath('data.student_id', $student->id)
        ->assertJsonPath('data.course_id',  $course->id);
});

it('evita la inscripción duplicada', function () {
    $student = Student::factory()->create();
    $course  = Course::factory()->create();
    \App\Domain\Enrollment\Models\Enrollment::factory()->create([
        'student_id' => $student->id,
        'course_id'  => $course->id,
    ]);
    $payload = ['student_id' => $student->id, 'course_id' => $course->id];
    postJson('/api/v1/enrollments', $payload)
        ->assertStatus(409);
});


it('No permite inscribir a un curso inexistente', function () {
    $user = User::factory()->create(['is_admin' => true]);
    Sanctum::actingAs($user);

    $student = Student::factory()->create();

    $payload = [
        'student_id' => $student->id,
        'course_id' => 9999, // ID de curso inexistente
    ];

   postJson('/api/v1/enrollments', $payload)
    ->assertStatus(422)
    ->assertJsonValidationErrors(['course_id']);
});

it('No permite inscribir dos veces al mismo curso', function () {
    $user = User::factory()->create(['is_admin' => true]);
    Sanctum::actingAs($user);

    $student = Student::factory()->create();
    $course = Course::factory()->create();

    $payload = [
        'student_id' => $student->id,
        'course_id' => $course->id,
    ];

    postJson('/api/v1/enrollments', $payload)->assertCreated();
    // Segundo intento
    postJson('/api/v1/enrollments', $payload)->assertStatus(409);
});


it('Valida que student_id y course_id sean requeridos', function () {
    $user = User::factory()->create(['is_admin' => true]);
    Sanctum::actingAs($user);

    postJson('/api/v1/enrollments', [])->assertStatus(422)
        ->assertJsonValidationErrors(['student_id', 'course_id']);
});