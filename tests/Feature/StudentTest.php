<?php

use App\Domain\Student\Models\Student;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);
});

it('Puede listar estudiantes', function () {
    Student::factory()->count(2)->create();
    getJson('/api/v1/students')
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('Puede ver un estudiante', function () {
    $student = Student::factory()->create();
    getJson("/api/v1/students/{$student->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $student->id);
});

it('Puede crear un estudiante', function () {
    $payload = [
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john@example.com',
    ];
    postJson('/api/v1/students', $payload)
        ->assertCreated()
        ->assertJsonPath('data.email', 'john@example.com');
});

it('Puede actualizar un estudiante', function () {
    $student = Student::factory()->create();
    putJson("/api/v1/students/{$student->id}", ['first_name' => 'Jane'])
        ->assertOk()
        ->assertJsonPath('data.first_name', 'Jane');
});

it('Puede eliminar un estudiante', function () {
    $student = Student::factory()->create();
    deleteJson("/api/v1/students/{$student->id}")
        ->assertNoContent();
    $this->assertDatabaseMissing('students', ['id' => $student->id]);
});
