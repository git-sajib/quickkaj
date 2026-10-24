<?php

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\SetLocale;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->alias([
            'admin' => AdminOnly::class,
            'setlocale' => SetLocale::class,
        ]);

        // When an authenticated user hits a guest-only route (e.g. /login),
        // redirect to the admin dashboard instead of route('home') which needs a locale param.
        RedirectIfAuthenticated::redirectUsing(
            fn () => route('admin.dashboard')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
