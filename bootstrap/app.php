<?php

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
            // 'isAdmin'=>\App\http\Middleware\CheckMembership::class
            // 'role'=>\App\http\Middleware\RoleMiddleware::class

        ]);
        //nah ini untuk yang di controller yang auth itu loh
        $middleware->redirectGuestsTo(
            fn (Request $request)=>route('login.form')
        );
    //untuk middlaware csrf, yang harus di blade
    //kalau gak pake ini,nanti gak bisa di chek di thunder client, harus blade 
        $middleware->validateCsrfTokens(except: [
            '*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );
    })->create();
