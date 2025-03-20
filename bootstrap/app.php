<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens([
            'webauthn/login',
            'webauthn/login/options',
            'webauthn/register',
            'webauthn/register/options',
            'entries/clock-in/api',
            'entries/clock-out/api',
            'entries/biometric/login',
            'employee/biometric/register'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
