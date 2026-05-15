<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CotizacionServicio extends Pivot
{
    protected $table = 'cotizacion_servicio';

    public $incrementing = true;

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
}
