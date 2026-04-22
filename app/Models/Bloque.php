<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloque extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bloques';

    protected $fillable = [
        'color',
        'descripcion',
    ];

    public function espacios()
    {
        return $this->hasMany(Espacio::class);
    }
}
