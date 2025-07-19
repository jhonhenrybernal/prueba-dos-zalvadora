<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Student\Repositories\StudentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\QueryParameter;

/**
 * @tags Estudiantes
 */
class StudentController extends Controller
{
    public function __construct(private StudentRepositoryInterface $students)
    {
        // $this->authorizeResource(\App\Domain\Student\Models\Student::class, 'student');
    }

    /**
     * Lista los estudiantes.
     *
     * Obtiene la lista de estudiantes, permite incluir cursos relacionados.
     *
     * @response array{data: StudentResource[]}
     */
    #[QueryParameter('with_courses', description: 'Incluye los cursos en los que está inscrito cada estudiante', type: 'bool')]
    #[QueryParameter('email', description: 'Filtrar por email exacto', type: 'string')]
    public function index(Request $request)
    {
        // Ejemplo: soporte para filtros vía query params
        $query = \App\Domain\Student\Models\Student::query();

        if ($request->boolean('with_courses')) {
            $query->withCourses();
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        $estudiantes = $query->paginate(10);
        return StudentResource::collection($estudiantes);
    }

    /**
     * Crea un nuevo estudiante.
     *
     * @response 201 StudentResource
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->students->create($request->validated());
        return (new StudentResource($student))->response()->setStatusCode(201);
    }

    /**
     * Muestra un estudiante específico.
     *
     * @param int $id ID del estudiante
     * @response StudentResource
     */
    public function show(int $id)
    {
        $student = $this->students->find($id);
        return new StudentResource($student);
    }

    /**
     * Actualiza un estudiante.
     *
     * @param int $id ID del estudiante
     * @response StudentResource
     */
    public function update(UpdateStudentRequest $request, int $id)
    {
        $student = $this->students->update($id, $request->validated());
        return new StudentResource($student);
    }

    /**
     * Elimina un estudiante.
     *
     * @param int $id ID del estudiante
     * @response 204
     */
    public function destroy(int $id): Response
    {
        $this->students->delete($id);
        return response()->noContent();
    }

    /**
     * Estudiantes con sus cursos.
     *
     * Lista todos los estudiantes junto con los cursos en los que están inscritos.
     *
     * @response array{data: StudentResource[]}
     */
    public function withCourses()
    {
        $students = $this->students->withCourses();
        return StudentResource::collection($students);
    }
}
