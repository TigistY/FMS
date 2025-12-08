<?php
<<<<<<< HEAD
use App\Http\Middleware\MyCustomMiddleware; // Middleware ፋይልህን import አድርግ
=======

>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
     $middleware->alias([
            'my_checker' => MyCustomMiddleware::class, // አሊያሱን (alias) እዚህ ይመዝግባል
        ]);
=======
        //
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
<<<<<<< HEAD

=======
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
