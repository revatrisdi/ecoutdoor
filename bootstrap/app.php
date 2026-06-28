<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Exclude Xendit webhook from CSRF verification
        $middleware->validateCsrfTokens(except: [
            '/xendit/webhook',
        ]);

        // Alias middleware untuk proteksi halaman admin
        $middleware->alias([
            'is.admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
        // VERCEL DEBUG: Catch the original exception before it tries to render a view!
        $exceptions->render(function (\Throwable $e, Request $request) {
            echo "<h1>ORIGINAL EXCEPTION CAUGHT IN HANDLER!</h1>";
            echo "<pre>" . (string) $e . "</pre>";
            exit;
        });
    })->create();

// VERCEL SPECIFIC: Override storage path to /tmp because Vercel is Read-Only
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $storagePath = '/tmp/storage';
    @mkdir($storagePath, 0777, true);
    @mkdir($storagePath.'/framework/cache/data', 0777, true);
    @mkdir($storagePath.'/framework/views', 0777, true);
    @mkdir($storagePath.'/framework/sessions', 0777, true);
    @mkdir($storagePath.'/logs', 0777, true);
    $app->useStoragePath($storagePath);
}

return $app;
