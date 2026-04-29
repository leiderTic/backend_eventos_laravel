<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            'Evento Social',
            'Evento Corporativo',
            'Feria y Exposición',
            'Conciertos y Espectáculos',
        ];

        foreach ($eventos as $descripcion) {
            Evento::firstOrCreate([
                'descripcion' => $descripcion,
            ]);
        }
    }
}
