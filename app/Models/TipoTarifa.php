<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTarifa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_tarifas';

    protected $fillable = ['nombre'];

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }
}
