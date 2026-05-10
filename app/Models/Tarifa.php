<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarifa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tarifas';

    protected $fillable = [
        'precio_dia',
        'evento_id',
        'temporada_id',
        'espacio_id',
    ];

    protected $casts = [
        'precio_dia' => 'decimal:2',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }
}
