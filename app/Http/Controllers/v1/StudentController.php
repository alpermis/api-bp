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
    public function GetStudent(Request $request): JsonResponse
    {
        return $this->success([
            'ad' => 'Alp',
            'soyad' => 'Ermiş'
        ]);
    }

    /**
     * Set student name (mock action).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function SetStudentName(Request $request): JsonResponse
    {
        $ad = $request->input('ad');
        $soyad = $request->input('soyad');

        return $this->success([
            'message' => 'Student name updated successfully (mock)',
            'data' => [
                'ad' => $ad,
                'soyad' => $soyad
            ]
        ]);
    }

    /**
     * Get general information (no authentication required).
     *
     * @return JsonResponse
     */
    public function GetInformation(): JsonResponse
    {
        return $this->success([
            'information' => 'Test bilgisi',
            'description' => 'Test açıklaması'
        ]);
    }
}
