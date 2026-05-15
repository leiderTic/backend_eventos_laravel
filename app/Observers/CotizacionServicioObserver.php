<?php

namespace App\Observers;

use App\Models\CotizacionServicio;

class CotizacionServicioObserver
{
    public function saved(CotizacionServicio $pivot)
    {
        $pivot->load('cotizacion');
        if ($pivot->cotizacion) {
            $pivot->cotizacion->refreshTotals();
        }
    }

    public function deleted(CotizacionServicio $pivot)
    {
        $pivot->load('cotizacion');
        if ($pivot->cotizacion) {
            $pivot->cotizacion->refreshTotals();
        }
    }
}
