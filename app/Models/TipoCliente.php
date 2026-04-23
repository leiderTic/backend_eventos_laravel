<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_clientes';

    protected $fillable = [
        'descripcion',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
