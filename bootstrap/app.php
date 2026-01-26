<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Laravel aplikācijas konfigurācijas sākumpunkts.
return Application::configure(basePath: dirname(__DIR__))
    // Norāda maršrutu failus un veselības pārbaudes ceļu.
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Pievieno globālos vai alias middleware.
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // "admin" alias lieto, lai aizsargātu admin sadaļas maršrutus.
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);
    })
    // Vietne, kur konfigurēt izņēmumu apstrādi.
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
