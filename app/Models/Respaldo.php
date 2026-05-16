<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respaldo extends Model
{
    use HasFactory;

    protected $fillable = ['archivo_path', 'id_tipo_respaldo', 'cotizacion_id'];

    public function tipoRespaldo()
    {
        return $this->belongsTo(TipoRespaldo::class, 'id_tipo_respaldo');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
}
