<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $table = 'reuniones';
    protected $fillable = [
        'cotizacion_id',
        'user_id',
        'fecha',
        'hora',
        'modalidad_id',
        'observaciones',
        'estado'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class);
    }

    public function acta()
    {
        return $this->hasOne(Acta::class);
    }
}
