<?php

use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Create The Application (Laravel 11+ style)
|--------------------------------------------------------------------------
*/

return Application::configure(basePath: dirname(__DIR__))
    // Configure exceptions handler remains the same
    ->withExceptions(function () {
        // Default handler binding (existing App\Exceptions\Handler)
    })
    // Configure middleware: global, groups, route middleware
    ->withMiddleware(function ($middleware) {
        // Global middleware (from old Http Kernel)
        $middleware->append([
            \App\Http\Middleware\TrustProxies::class,
            Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \App\Http\Middleware\CORS::class,
        ]);

        // Middleware groups
        $middleware->group('web', [
            // Preserve existing 'web' stack semantics
            \App\Http\Middleware\EncryptCookies::class,
            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Localization::class,
        ]);

        $middleware->group('api', [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Route middleware aliases
        $middleware->alias([
            // Core aliases
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'bindings' => Illuminate\Routing\Middleware\SubstituteBindings::class,
            'cache.headers' => Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'guestAdmin' => \App\Http\Middleware\RedirectAdminAuthenticated::class,
            'password.confirm' => Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            // Project-specific aliases
            'adminAuth' => \App\Http\Middleware\AdminAuth::class,
            'companyAuth' => \App\Http\Middleware\CompanyAuth::class,
            'checkMcqScreening' => \App\Http\Middleware\CheckMcqScreening::class,
            'isCmpnyCandLoggedIn' => \App\Http\Middleware\IsCmpnyCandLogIn::class,
            'checkCountry' => \App\Http\Middleware\CheckCountry::class,
        ]);
    })
    // Configure routing keeps existing route files
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php'
    )
    // Configure providers left as default discovery; existing providers will be loaded
    ->withProviders([
        // Keep default providers and any in config/app.php
    ])
    ->create();
