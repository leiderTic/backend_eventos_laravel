<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEspacio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_espacios';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class);
    }
}
