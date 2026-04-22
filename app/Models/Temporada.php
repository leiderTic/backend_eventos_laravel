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
        'fecha_ini',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_ini' => 'date',
        'fecha_fin' => 'date',
    ];

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }
}
