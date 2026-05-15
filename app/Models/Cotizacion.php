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
    ];

    protected $casts = [
        "fecha_ini" => "date",
        "fecha_fin" => "date",
        "vencido" => "boolean",
        "paso" => "integer",
        "monto_tarifas" => "decimal:2",
        "monto_servicios" => "decimal:2",
        "monto_total" => "decimal:2",
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
     * Recalcula y persiste los montos desnormalizados.
     */
    public function refreshTotals()
    {
        // Suma de tarifas: dias * precio_aplicado (donde estado = true)
        $this->monto_tarifas = $this->tarifas()
            ->wherePivot('estado', true)
            ->get()
            ->sum(function ($tarifa) {
                return $tarifa->pivot->dias * $tarifa->pivot->precio_aplicado;
            });

        // Suma de servicios: cantidad * dias * precio_aplicado (donde estado = true)
        $this->monto_servicios = $this->servicios()
            ->wherePivot('estado', true)
            ->get()
            ->sum(function ($servicio) {
                return $servicio->pivot->cantidad * $servicio->pivot->dias * $servicio->pivot->precio_aplicado;
            });

        $this->monto_total = $this->monto_tarifas + $this->monto_servicios;

        $this->saveQuietly();
    }

    public function historial()
    {
        return $this->hasMany(CotizacionHistorial::class);
    }
}
