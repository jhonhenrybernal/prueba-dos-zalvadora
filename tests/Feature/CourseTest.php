<?php
use App\Domain\Course\Models\Course;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => true]);
    Sanctum::actingAs($this->user); // ¡necesario!
});

it('Puede obtener la lista de cursos', function () {
    Course::factory()->count(3)->create(['owner_id' => $this->user->id]);
    getJson('/api/v1/courses')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

it('Puede ver un solo curso', function () {
    $course = Course::factory()->create(['owner_id' => $this->user->id]);
    getJson("/api/v1/courses/{$course->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $course->id);
});

it('Puede crear un curso', function () {
    $payload = [
        'title' => 'Test Course',
        'description' => 'Desc',
        'start_date' => Carbon::now()->toDateString(),
        'end_date' => Carbon::now()->addDay()->toDateString(),
    ];
    postJson('/api/v1/courses', $payload)
        ->assertCreated()
        ->assertJsonPath('data.title', 'Test Course');
});

it('Puede actualizar un curso', function () {
    $course = Course::factory()->create(['owner_id' => $this->user->id]);
    putJson("/api/v1/courses/{$course->id}", ['title' => 'Updated Title'])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated Title');
});

it('Puede eliminar un curso', function () {
    $course = Course::factory()->create(['owner_id' => $this->user->id]);
    deleteJson("/api/v1/courses/{$course->id}")
        ->assertNoContent();
    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});


it('Deniega crear curso si no es admin', function () {
    $user = User::factory()->create(['is_admin' => false]);
    Sanctum::actingAs($user);

    $payload = [
        'title' => 'No allowed',
        'description' => 'Text',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
    ];

    postJson('/api/v1/courses', $payload)
        ->assertForbidden();
});