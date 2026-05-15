<?php

namespace App\Observers;

use App\Models\CotizacionTarifa;

class CotizacionTarifaObserver
{
    public function saved(CotizacionTarifa $pivot)
    {
        $pivot->load('cotizacion');
        if ($pivot->cotizacion) {
            $pivot->cotizacion->refreshTotals();
        }
    }

    public function deleted(CotizacionTarifa $pivot)
    {
        $pivot->load('cotizacion');
        if ($pivot->cotizacion) {
            $pivot->cotizacion->refreshTotals();
        }
    }
}
