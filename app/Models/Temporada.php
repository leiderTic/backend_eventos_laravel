<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temporada extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'temporadas';

    protected $fillable = [
        'descripcion',
        'mes_inicio',
        'mes_fin',
    ];

    protected $casts = [
        'mes_inicio' => 'integer',
        'mes_fin' => 'integer',
    ];

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }
}
