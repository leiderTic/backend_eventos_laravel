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
        'descripcion',
        'precio_dia',
    ];

    protected $casts = [
        'precio_dia' => 'decimal:2',
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class);
    }
}
