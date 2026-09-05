<?php

use App\Http\Middleware\ActivePoliceMiddleware;
use App\Http\Middleware\AdminMidlleware;
use App\Http\Middleware\PermissionMiddlleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission'=>PermissionMiddlleware::class,
            'admin'=>AdminMidlleware::class,
            'active.police' => ActivePoliceMiddleware::class,

        ]);
        $middleware->redirectGuestsTo(
            fn (Request $request)=>route('login.form')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );
    })->create();
