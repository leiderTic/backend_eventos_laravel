<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCrm extends Model
{
    use HasFactory;

    protected $table = 'tipo_crms';
    protected $fillable = ['descripcion'];

    public function crms()
    {
        return $this->hasMany(Crm::class);
    }
}
