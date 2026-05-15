<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CotizacionTarifa extends Pivot
{
    protected $table = 'cotizacion_tarifa';

    public $incrementing = true;

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
}
