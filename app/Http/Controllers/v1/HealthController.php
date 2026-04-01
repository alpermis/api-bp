<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;

class HealthController extends Controller
{
    public function index()
    {
        return $this->success([
            'status' => 'ok',
            'version' => '1.0.0',
            'app'    => config('app.name'),
            'time'   => now()->toIso8601String(),
        ]);
    }
}
