<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use SoftDeletes;
    protected $table = "cotizaciones";

    protected $fillable = [
        "descripcion",
        "fecha_ini",
        "fecha_fin",
        "paso",
        "vencido",
        "user_id",
        "evento_id",
    ];

    protected $casts = [
        "fecha_ini" => "date",
        "fecha_fin" => "date",
        "vencido" => "boolean",
        "paso" => "integer",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'cotizacion_persona')
                    ->withPivot('estado')
                    ->withTimestamps();
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cotizacion_servicio')
                    ->withPivot('cantidad', 'precio_aplicado', 'estado')
                    ->withTimestamps();
    }

    public function espacios()
    {
        return $this->belongsToMany(Espacio::class, 'cotizacion_espacio')
                    ->withPivot('dias', 'precio_aplicado', 'estado')
                    ->withTimestamps();
    }
}
