<?php

    use App\Http\Middleware\CheckAuthenticatedUser;
    use Illuminate\Support\Facades\Route;
    use App\Support\ApiResponse;
    use App\Http\Controllers\v1\HealthController;
    use App\Http\Controllers\v1\StudentController;

    /*
    |--------------------------------------------------------------------------
    | API V1 Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('v1')
         ->group(function () {

            Route::get('/health', [HealthController::class, 'index']);
            Route::get('/information', [StudentController::class, 'getInformation']);

            Route::middleware(['auth.user'])->group(function () {
                Route::get('/student', [StudentController::class, 'getStudent'])->name('v1.student.get');
                Route::put('/student', [StudentController::class, 'setStudent'])->name('v1.student.set');
                Route::post('/student', [StudentController::class, 'createStudent'])->name('v1.student.create');
            });
        })
    ;

    Route::fallback(function () {
        return ApiResponse::error('Route not found', 'ROUTE_NOT_FOUND', 404);
    });
