<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CotizacionServicio;
use App\Models\CotizacionTarifa;
use App\Observers\CotizacionServicioObserver;
use App\Observers\CotizacionTarifaObserver;

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
        CotizacionServicio::observe(CotizacionServicioObserver::class);
        CotizacionTarifa::observe(CotizacionTarifaObserver::class);
    }
}
