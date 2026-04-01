<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

//openapi.json public/docs/ altinda direkt publish ediliyor.
/*Route::get('/openapi.yaml', function () {
    $path = base_path('openapi.yaml');

    if (!file_exists($path)) {
        abort(404, 'openapi.yaml not found');
    }

    return response(
        file_get_contents($path),
        200,
        [
            'Content-Type' => 'application/yaml; charset=utf-8',
            'Content-Disposition' => 'inline'
        ]
    );
});*/
