<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    protected $table = 'crms';
    protected $fillable = [
        'cotizacion_id',
        'user_id',
        'tipo_crm_id',
        'fecha',
        'descripcion',
        'resultado'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tipoCrm()
    {
        return $this->belongsTo(TipoCrm::class, 'tipo_crm_id');
    }
}
