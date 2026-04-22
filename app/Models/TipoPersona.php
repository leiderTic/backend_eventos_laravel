<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoPersona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_personas';

    protected $fillable = [
        'descripcion',
    ];

    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}
