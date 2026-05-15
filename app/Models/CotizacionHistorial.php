<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHistorial extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones_historial';

    protected $fillable = [
        'cotizacion_id',
        'user_id',
        'accion',
        'motivo',
        'cambios',
    ];

    protected $casts = [
        'cambios' => 'array',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
