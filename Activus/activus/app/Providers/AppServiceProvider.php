<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Evita ejecutar código si estamos en consola (artisan, composer, etc.)
        if ($this->app->runningInConsole()) {
            return;
        }

        // Ahora sí, solo si es una petición web:
        if (function_exists('configuracion_activa')) {
            View::share('configuracion', configuracion_activa());
        }
    }
}
