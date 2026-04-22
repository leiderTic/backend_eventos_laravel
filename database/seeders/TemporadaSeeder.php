<?php

namespace Database\Seeders;

use App\Models\Temporada;
use Illuminate\Database\Seeder;

class TemporadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Temporada::updateOrCreate(
            ['descripcion' => 'Temporada baja'],
            [
                'mes_inicio' => 1,
                'mes_fin' => 6,
            ]
        );

        Temporada::updateOrCreate(
            ['descripcion' => 'Temporada alta'],
            [
                'mes_inicio' => 7,
                'mes_fin' => 12,
            ]
        );
    }
}
