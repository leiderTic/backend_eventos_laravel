<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRespaldo extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion'];

    public function respaldos()
    {
        return $this->hasMany(Respaldo::class, 'id_tipo_respaldo');
    }
}
