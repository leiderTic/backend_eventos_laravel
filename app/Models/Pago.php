<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto_pagado',
        'fecha_deposito',
        'nro_comprobante',
        'boucher_path',
        'banco_id',
        'estado',
        'verificado_por',
        'fecha_verificacion',
        'motivo_rechazo',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function verificadoPor()
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_pago')
                    ->withTimestamps();
    }
}
