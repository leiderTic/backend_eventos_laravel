<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modalidad;
use App\Models\TipoCrm;

class CrmReunionSeeder extends Seeder
{
    public function run(): void
    {
        // Modalidades de Reunión
        $modalidades = ['Presencial', 'Virtual'];
        foreach ($modalidades as $m) {
            Modalidad::updateOrCreate(['descripcion' => $m]);
        }

        // Tipos de CRM / Seguimiento
        $tipos = ['Llamada', 'Reunión', 'Correo', 'WhatsApp'];
        foreach ($tipos as $t) {
            TipoCrm::updateOrCreate(['descripcion' => $t]);
        }
    }
}
