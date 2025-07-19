<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\QueryParameter;

/**
 * @tags Cursos
 */
class CourseController extends Controller
{
    public function __construct(private CourseRepositoryInterface $courses)
    {
    }

    /**
     * Lista los cursos.
     *
     * Obtiene la lista de cursos, opcionalmente filtrando por título, cursos activos o incluyendo estudiantes inscritos.
     *
     * @response array{data: CourseResource[]}
     */
    #[QueryParameter('with_students', description: 'Incluye estudiantes inscritos en el curso', type: 'bool')]
    #[QueryParameter('titulo', description: 'Filtra cursos cuyo título contenga este texto', type: 'string')]
    #[QueryParameter('activos', description: 'Filtra solo los cursos activos', type: 'bool')]
    public function index(Request $request)
    {
        $query = \App\Domain\Course\Models\Course::query();

        if ($request->boolean('with_students')) {
            $query->withStudents();
        }

        if ($request->filled('titulo')) {
            $query->titulo($request->input('titulo'));
        }

        if ($request->boolean('activos')) {
            $query->activos();
        }

        $cursos = $query->paginate(10);
        return CourseResource::collection($cursos);
    }

    /**
     * Muestra un curso específico.
     *
     * @param int $id ID del curso
     * @response CourseResource
     */
    public function show(int $id)
    {
        return new CourseResource($this->courses->find($id));
    }

    /**
     * Crea un nuevo curso.
     *
     * @response 201 CourseResource
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $data = $request->validated();
        $data['owner_id'] = auth()->user()?->id;
        $course = $this->courses->save($data);

        return (new CourseResource($course))->response()->setStatusCode(201);
    }

    /**
     * Actualiza un curso existente.
     *
     * @param int $id ID del curso
     * @response CourseResource
     */
    public function update(UpdateCourseRequest $request, int $id)
    {
        $course = $this->courses->update($id, $request->validated());
        return new CourseResource($course);
    }

    /**
     * Elimina un curso.
     *
     * @param int $id ID del curso
     * @response 204
     */
    public function destroy(int $id)
    {
        $this->courses->delete($id);
        return response()->noContent();
    }
}
