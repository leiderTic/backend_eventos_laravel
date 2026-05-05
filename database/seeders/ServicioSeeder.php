<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            ['codigo' => 'S01', 'nombre' => 'Sillas negras', 'unidad' => 'Día', 'precio' => 8, 'porEv' => false],
            ['codigo' => 'S02', 'nombre' => 'Sillas plásticas', 'unidad' => 'Día', 'precio' => 5, 'porEv' => false],
            ['codigo' => 'S03', 'nombre' => 'Mesas negras rectangulares', 'unidad' => 'Día', 'precio' => 15, 'porEv' => false],
            ['codigo' => 'S04', 'nombre' => 'Mesas redondas', 'unidad' => 'Día', 'precio' => 15, 'porEv' => false],
            ['codigo' => 'S05', 'nombre' => 'Mesas plásticas', 'unidad' => 'Día', 'precio' => 8, 'porEv' => false],
            ['codigo' => 'S06', 'nombre' => 'Fundas para sillas negras', 'unidad' => 'Día', 'precio' => 3, 'porEv' => false],
            ['codigo' => 'S07', 'nombre' => 'Lounge (4 puff + mesa)', 'unidad' => 'Día', 'precio' => 200, 'porEv' => false],
            ['codigo' => 'S08', 'nombre' => 'Paneles + iluminación + energía', 'unidad' => 'Evento', 'precio' => 120, 'porEv' => true, 'nota' => 'Por metro lineal'],
            ['codigo' => 'S09', 'nombre' => 'Equipo de sonido + 1 mic', 'unidad' => 'Día', 'precio' => 400, 'porEv' => false],
            ['codigo' => 'S10', 'nombre' => 'Sonido c/consola + 1 mic', 'unidad' => 'Día', 'precio' => 600, 'porEv' => false],
            ['codigo' => 'S11', 'nombre' => 'Micrófonos inalámbricos', 'unidad' => 'Día', 'precio' => 160, 'porEv' => false],
            ['codigo' => 'S12', 'nombre' => 'Micrófono solapero', 'unidad' => 'Día', 'precio' => 200, 'porEv' => false],
            ['codigo' => 'S13', 'nombre' => 'Micrófono headset', 'unidad' => 'Día', 'precio' => 200, 'porEv' => false],
            ['codigo' => 'S14', 'nombre' => 'Micrófono cuello de ganso', 'unidad' => 'Día', 'precio' => 150, 'porEv' => false],
            ['codigo' => 'S15', 'nombre' => 'Tarimas 2×2 m (0.9 m alto)', 'unidad' => 'Día', 'precio' => 50, 'porEv' => false],
            ['codigo' => 'S16', 'nombre' => 'Estufas', 'unidad' => 'Día', 'precio' => 150, 'porEv' => false],
            ['codigo' => 'S17', 'nombre' => 'TV 55" c/pedestal', 'unidad' => 'Día', 'precio' => 300, 'porEv' => false],
            ['codigo' => 'S18', 'nombre' => 'Vallas', 'unidad' => 'Evento', 'precio' => 20, 'porEv' => true],
            ['codigo' => 'S19', 'nombre' => 'Tótem publicitario', 'unidad' => 'Día', 'precio' => 300, 'porEv' => false],
        ];

        foreach ($servicios as $servicio) {
            Servicio::updateOrCreate(['codigo' => $servicio['codigo']], $servicio);
        }
    }
}
