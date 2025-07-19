<?php
namespace App\Http\Controllers\Api\V1;

use App\Domain\Enrollment\Services\EnrollmentDomainService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\Response;
use DomainException;

class EnrollmentController extends Controller
{
    public function __construct(private EnrollmentDomainService $service)
    {
    }

    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();

        try {
            $enrollment = $this->service->enroll($data['student_id'], $data['course_id']);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }

        return (new EnrollmentResource($enrollment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
