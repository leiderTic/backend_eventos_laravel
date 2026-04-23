<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'ci_nit',
        'nombre',
        'correo',
        'telefono',
        'tipo_cliente_id',
        'cliente_id',
    ];

    public function tipoCliente()
    {
        return $this->belongsTo(TipoCliente::class);
    }

    /**
     * Si esta es una institución, tiene muchos contactos.
     */
    public function contactos()
    {
        return $this->hasMany(Cliente::class, 'cliente_id');
    }

    /**
     * Si este es un contacto, pertenece a una institución.
     */
    public function institucion()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_cliente')
                    ->withTimestamps();
    }
}
