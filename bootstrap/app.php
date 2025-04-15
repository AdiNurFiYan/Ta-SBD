<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'prevent-back-history' => PreventBackHistory::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();