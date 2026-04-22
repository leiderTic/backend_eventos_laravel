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
        $currentYear = date('Y');

        Temporada::updateOrCreate(
            ['descripcion' => 'Temporada baja'],
            [
                'fecha_ini' => "$currentYear-01-01",
                'fecha_fin' => "$currentYear-06-30",
            ]
        );

        Temporada::updateOrCreate(
            ['descripcion' => 'Temporada alta'],
            [
                'fecha_ini' => "$currentYear-07-01",
                'fecha_fin' => "$currentYear-12-31",
            ]
        );
    }
}
