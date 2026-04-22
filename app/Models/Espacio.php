<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Espacio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'espacios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'dias_max',
        'area_m2',
        'aforo',
        'tipo_espacio_id',
        'bloque_id',
    ];

    protected $casts = [
        'area_m2' => 'decimal:2',
        'dias_max' => 'integer',
        'aforo' => 'integer',
    ];

    public function tipoEspacio()
    {
        return $this->belongsTo(TipoEspacio::class);
    }

    public function bloque()
    {
        return $this->belongsTo(Bloque::class);
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_espacio')
                    ->withPivot('dias', 'precio_aplicado')
                    ->withTimestamps();
    }
}
