<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use SoftDeletes;
    protected $table = "cotizaciones";

    protected $fillable = [
        "codigo",
        "correlativo",
        "descripcion",
        "fecha_ini",
        "fecha_fin",
        "paso",
        "vencido",
        "user_id",
        "evento_id",
        "monto_tarifas",
        "monto_servicios",
        "monto_total",
        "monto_total_pagado",
    ];

    protected $casts = [
        "fecha_ini" => "date",
        "fecha_fin" => "date",
        "vencido" => "boolean",
        "paso" => "integer",
        "monto_tarifas" => "decimal:2",
        "monto_servicios" => "decimal:2",
        "monto_total" => "decimal:2",
        "monto_total_pagado" => "decimal:2",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cotizacion_cliente')
                    ->withPivot('estado')
                    ->withTimestamps();
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cotizacion_servicio')
                    ->using(CotizacionServicio::class)
                    ->withPivot('cantidad', 'dias', 'precio_aplicado', 'estado')
                    ->withTimestamps();
    }

    public function tarifas()
    {
        return $this->belongsToMany(Tarifa::class, 'cotizacion_tarifa')
                    ->using(CotizacionTarifa::class)
                    ->withPivot('dias', 'precio_aplicado', 'estado')
                    ->withTimestamps();
    }

    /**
     * Calcula los montos sin persistirlos.
     * Útil para vistas previas o auditoría previa al guardado.
     */
    public function calculateTotals()
    {
        $montoTarifas = $this->tarifas()
            ->wherePivot('estado', true)
            ->get()
            ->sum(function ($tarifa) {
                return (float)$tarifa->pivot->dias * (float)$tarifa->pivot->precio_aplicado;
            });

        $montoServicios = $this->servicios()
            ->wherePivot('estado', true)
            ->get()
            ->sum(function ($servicio) {
                return (float)$servicio->pivot->cantidad * (float)$servicio->pivot->dias * (float)$servicio->pivot->precio_aplicado;
            });

        return [
            'monto_tarifas' => $montoTarifas,
            'monto_servicios' => $montoServicios,
            'monto_total' => $montoTarifas + $montoServicios
        ];
    }

    /**
     * Recalcula y persiste los montos desnormalizados.
     */
    public function refreshTotals()
    {
        $totals = $this->calculateTotals();
        
        $this->monto_tarifas = $totals['monto_tarifas'];
        $this->monto_servicios = $totals['monto_servicios'];
        $this->monto_total = $totals['monto_total'];

        $this->saveQuietly();
    }

    public function historial()
    {
        return $this->hasMany(CotizacionHistorial::class);
    }

    public function pagos()
    {
        return $this->belongsToMany(Pago::class, 'cotizacion_pago')
                    ->withTimestamps();
    }

    public function respaldos()
    {
        return $this->hasMany(Respaldo::class);
    }

    public function reuniones()
    {
        return $this->hasMany(Reunion::class);
    }

    public function crms()
    {
        return $this->hasMany(Crm::class);
    }
}
