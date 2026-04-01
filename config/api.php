<?php

return [
    'user' => env('API_USER'),
    'pass' => env('API_PASS'),
    'jwt_secret' => env('JWT_SECRET'),
    'jwt_ttl' => env('JWT_TTL', 600), // saniye
    'version' => env('API_VERSION', 'v1'),
];
