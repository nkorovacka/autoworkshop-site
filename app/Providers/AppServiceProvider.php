<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Reģistrē aplikācijas servisa objektus un konfigurācijas iestatījumus.
     */
    public function register(): void
    {
        // Šeit parasti reģistrējam:
        // - servisa konteinerī piesaistītus interfeisus/klases,
        // - konfigurācijas papildinājumus,
        // - trešo pušu servisu inicializāciju.
    }

    /**
     * Izpilda aplikācijas sākotnējo konfigurēšanu (bootstrapping).
     */
    public function boot(): void
    {
        // Šeit parasti ievieto:
        // - globālus iestatījumus (piem., lokalizāciju, laika zonu),
        // - validācijas paplašinājumus,
        // - view koplietošanas datus,
        // - makros vai citus framework paplašinājumus.
    }
}
