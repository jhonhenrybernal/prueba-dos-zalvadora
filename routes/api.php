<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use App\Http\Controllers\Api\V1\AuthController;


Route::get('/prueba', function () {
    return response()->json([
        'mensaje' => '¡Funciona la API!',
        'status' => 'ok'
    ]);
});
Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('courses/with-students',    [CourseController::class, 'withStudents'])
            ->middleware('can:viewAny,' . \App\Domain\Course\Models\Course::class);

        Route::get('courses/enrollment-count', [CourseController::class, 'enrollmentCount'])
            ->middleware('can:viewAny,' . \App\Domain\Course\Models\Course::class);

        Route::get('students/with-courses',    [StudentController::class, 'withCourses'])
            ->middleware('can:viewAny,' . \App\Domain\Student\Models\Student::class);

        Route::apiResource('courses', CourseController::class)
            ->middleware('can:viewAny,' . \App\Domain\Course\Models\Course::class);

        Route::apiResource('students', StudentController::class)
            ->middleware('can:viewAny,' . \App\Domain\Student\Models\Student::class);

        Route::post('enrollments', [EnrollmentController::class, 'store'])
            ->middleware('can:create,' . \App\Domain\Enrollment\Models\Enrollment::class);

        Route::get('enrollments', [EnrollmentController::class, 'index'])
            ->middleware('can:viewAny,' . \App\Domain\Enrollment\Models\Enrollment::class);
    });

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/v1/register', [AuthController::class, 'register']);