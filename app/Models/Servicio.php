<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_servicio')
                    ->withPivot('cantidad', 'precio_aplicado')
                    ->withTimestamps();
    }
}
