<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    use HasFactory;

    protected $fillable = ['reunion_id', 'archivo_path', 'resumen_acuerdos'];

    public function reunion()
    {
        return $this->belongsTo(Reunion::class);
    }
}
