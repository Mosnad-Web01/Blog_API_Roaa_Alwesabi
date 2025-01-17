<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // middleware global هنا
        \App\Http\Middleware\ErrorHandlerMiddleware::class,
        // ...
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // middleware الخاصة بالمسارات هنا
    ];
}
