<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware สำหรับกลุ่ม web
        ],

        'api' => [
            // Middleware สำหรับกลุ่ม api
        ],
    ];

    protected $routeMiddleware = [
        // Middleware ที่กำหนดเอง
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
