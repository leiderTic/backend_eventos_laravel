<?php

namespace Database\Seeders;

use App\Models\Bloque;
use App\Models\Espacio;
use App\Models\Tarifa;
use App\Models\Temporada;
use App\Models\TipoEspacio;
use App\Models\TipoTarifa;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bloques
        $bloquesData = [
            'ROJO' => '#ef4444', 
            'AMARILLO' => '#eab308', 
            'CENTRAL' => '#3b82f6', 
            'VERDE' => '#22c55e'
        ];
        $bloques = [];
        foreach ($bloquesData as $nombre => $color) {
            $bloques[$nombre] = Bloque::updateOrCreate(
                ['descripcion' => $nombre],
                ['color' => $color]
            )->id;
        }

        // 2. Tipos de Espacio
        $tiposData = ['Salón', 'Plaza', 'Teatro', 'Sala'];
        $tipos = [];
        foreach ($tiposData as $nombre) {
            $tipos[$nombre] = TipoEspacio::firstOrCreate(['nombre' => $nombre])->id;
        }

        // 3. Temporadas (Asegurar que existan)
        $this->call(TemporadaSeeder::class);
        $tempBaja = Temporada::where('descripcion', 'Temporada baja')->first()->id;
        $tempAlta = Temporada::where('descripcion', 'Temporada alta')->first()->id;

        // 4. Tipos de Tarifa
        $tipoTarifasData = ['Social', 'Corporativo', 'Feria', 'Concierto'];
        $tipoTarifas = [];
        foreach ($tipoTarifasData as $nombre) {
            $tipoTarifas[$nombre] = TipoTarifa::firstOrCreate(['nombre' => $nombre])->id;
        }

        // 5. Datos de Espacios y Tarifas
        // Formato array precios: [Social baja, Social alta, Corporativo baja, Corporativo alta, Feria baja, Feria alta, Concierto baja, Concierto alta]
        $espaciosData = [
            [
                'id' => 'SPO', 'nombre' => 'Salón Potosí', 'bloque' => 'ROJO', 'tipo' => 'Salón', 
                'm2' => 2013, 'aforo' => 0, 'incluye' => 'Oficina organizador, depósito y 2 baterías de baños',
                'precios' => [10000, 11800, 9800, 11600, 9400, 10200, 10000, 12000]
            ],
            [
                'id' => 'SCH', 'nombre' => 'Salón Chuquisaca', 'bloque' => 'ROJO', 'tipo' => 'Salón', 
                'm2' => 2425, 'aforo' => 0, 'incluye' => 'Batería de baños y acceso a depósito compartido',
                'precios' => [8000, 9400, 7900, 9100, 7200, 7800, 8200, 9600]
            ],
            [
                'id' => 'SLP', 'nombre' => 'Salón La Paz', 'bloque' => 'AMARILLO', 'tipo' => 'Salón', 
                'm2' => 2405, 'aforo' => 0, 'incluye' => 'Batería de baños integrada',
                'precios' => [6400, 7700, 6200, 7400, 5800, 6400, 6500, 7800]
            ],
            [
                'id' => 'SCO', 'nombre' => 'Salón Cochabamba', 'bloque' => 'AMARILLO', 'tipo' => 'Salón', 
                'm2' => 2366, 'aforo' => 0, 'incluye' => 'Acceso a baños del bloque',
                'precios' => [5600, 6900, 5500, 6700, 5100, 5600, 5700, 6900]
            ],
            [
                'id' => 'SCR', 'nombre' => 'Salón Santa Cruz', 'bloque' => 'VERDE', 'tipo' => 'Salón', 
                'm2' => 1671, 'aforo' => 0, 'incluye' => 'Baños compartidos bloque verde',
                'precios' => [4800, 6100, 4600, 5800, 4200, 4800, 4900, 6000]
            ],
            [
                'id' => 'PIN', 'nombre' => 'Plaza Integración', 'bloque' => 'AMARILLO', 'tipo' => 'Plaza', 
                'm2' => 1409, 'aforo' => 0, 'incluye' => 'Área de maniobra, acceso vehicular y servicios básicos',
                'precios' => [16000, 19000, 14000, 17000, 12000, 13000, 14000, 17000]
            ],
            [
                'id' => 'PEN', 'nombre' => 'Plaza Encuentro', 'bloque' => 'AMARILLO', 'tipo' => 'Plaza', 
                'm2' => 1105, 'aforo' => 0, 'incluye' => 'Área techada parcial, acceso vehicular',
                'precios' => [13500, 16000, 12000, 14500, 10500, 11500, 12000, 14500]
            ],
            [
                'id' => 'SPDM', 'nombre' => 'Salón Pedro Domingo Murillo', 'bloque' => 'VERDE', 'tipo' => 'Salón', 
                'm2' => 439, 'aforo' => 250, 'incluye' => 'Baños propios y acceso independiente',
                'precios' => [4800, 5800, 4500, 5500, 4200, 4700, 4500, 5500]
            ],
            [
                'id' => 'AIL', 'nombre' => 'Teatro Auditorio Illimani', 'bloque' => 'VERDE', 'tipo' => 'Teatro', 
                'm2' => 1218, 'aforo' => 800, 'incluye' => 'Equipo de sonido básico, proyector, camerinos y baños',
                'precios' => [6400, 7800, 6000, 7200, 5800, 6400, 6400, 7600]
            ],
            [
                'id' => 'SBE', 'nombre' => 'Sala Beni', 'bloque' => 'AMARILLO', 'tipo' => 'Sala', 
                'm2' => 219, 'aforo' => 0, 'incluye' => 'Baños compartidos',
                'precios' => [3600, 4400, 3400, 4200, 3200, 3500, 3500, 4200]
            ],
            [
                'id' => 'SOR', 'nombre' => 'Sala Oruro', 'bloque' => 'AMARILLO', 'tipo' => 'Sala', 
                'm2' => 467, 'aforo' => 0, 'incluye' => 'Baños compartidos',
                'precios' => [3200, 4000, 3000, 3800, 2900, 3200, 3200, 3800]
            ],
            [
                'id' => 'SLI', 'nombre' => 'Sala Litoral', 'bloque' => 'AMARILLO', 'tipo' => 'Sala', 
                'm2' => 372, 'aforo' => 0, 'incluye' => 'Baños compartidos',
                'precios' => [2800, 3500, 2600, 3300, 2600, 2900, 2800, 3400]
            ],
            [
                'id' => 'STA', 'nombre' => 'Sala Tarija', 'bloque' => 'VERDE', 'tipo' => 'Sala', 
                'm2' => 315, 'aforo' => 0, 'incluye' => 'Baños compartidos',
                'precios' => [2500, 3200, 2300, 3000, 2300, 2600, 2500, 3100]
            ],
        ];

        foreach ($espaciosData as $data) {
            $espacio = Espacio::updateOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'descripcion' => $data['incluye'],
                    'area_m2' => $data['m2'],
                    'aforo' => $data['aforo'],
                    'tipo_espacio_id' => $tipos[$data['tipo']],
                    'bloque_id' => $bloques[$data['bloque']],
                ]
            );

            // Crear las 4 tarifas (basadas en los tipos)
            foreach ($tipoTarifasData as $index => $nombreTipo) {
                $tipoId = $tipoTarifas[$nombreTipo];
                
                Tarifa::create([
                    'tipo_tarifa_id' => $tipoId,
                    'precio_dia' => $data['precios'][$index * 2], // Tomamos el primer precio
                    'espacio_id' => $espacio->id,
                ]);
            }
        }
    }
}
