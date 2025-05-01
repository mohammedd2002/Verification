<?php

use App\Http\Middleware\MerchantEnsureEmailIsVerified as MiddlewareMerchantEnsureEmailIsVerified;
use App\Http\Middleware\MerchantMiddleware;
use Illuminate\Auth\Middleware\MerchantEnsureEmailIsVerified;
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
            'merchant' => MerchantMiddleware::class,
            'merchantVerified' => MiddlewareMerchantEnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
