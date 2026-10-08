<?php

return [
    'host' => env('MAILMAN_HOST', 'http://localhost'),
    'port' => env('MAILMAN_PORT', '8001'),
    'api' => env('MAILMAN_API_VERSION', '3.0'),
    'admin_user' => env('MAILMAN_USERNAME', ''),
    'admin_pass' => env('MAILMAN_PASSWORD', ''),
];
