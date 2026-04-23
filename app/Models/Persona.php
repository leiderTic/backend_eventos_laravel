<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'ci_nit',
        'nombre',
        'correo',
        'telefono',
        'tipo_persona_id',
        'persona_id',
    ];

    public function tipoPersona()
    {
        return $this->belongsTo(TipoPersona::class);
    }

    /**
     * Si esta es una institución, tiene muchos contactos.
     */
    public function contactos()
    {
        return $this->hasMany(Persona::class, 'persona_id');
    }

    /**
     * Si este es un contacto, pertenece a una institución.
     */
    public function institucion()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_persona')
                    ->withTimestamps();
    }
}
