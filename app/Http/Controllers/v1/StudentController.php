<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Get authenticated student information.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudent(Request $request): JsonResponse
    {
        return $this->success([
            'name' => 'Alp',
            'lastname' => 'Ermiş'
        ]);
    }

    /**
     * Set student name and lastname (mock action).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setStudent(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'lastname' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                'VALIDATION_ERROR',
                400,
                $validator->errors()->toArray()
            );
        }

        $name = $request->input('name');
        $lastname = $request->input('lastname');

        return $this->success([
            'status' => 'OK',
            'message' => 'Student information updated successfully',
            'data' => [
                'name' => $name,
                'lastname' => $lastname
            ]
        ]);
    }

    /**
     * Get general information (no authentication required).
     *
     * @return JsonResponse
     */
    public function getInformation(): JsonResponse
    {
        return $this->success([
            'information' => 'Test information',
            'description' => 'Test description'
        ]);
    }
}
