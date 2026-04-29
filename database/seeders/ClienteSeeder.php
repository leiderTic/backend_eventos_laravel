<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\TipoCliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('es_BO');

        // 1. Crear Tipos de Cliente (Solo Institución y Persona de contacto)
        $tipoEmpresa = TipoCliente::firstOrCreate(['descripcion' => 'Institución']);
        $tipoContacto = TipoCliente::firstOrCreate(['descripcion' => 'Persona de contacto']);

        // 2. Crear Instituciones Reales de Bolivia y sus Contactos
        $nombresInstituciones = [
            'YPFB Corporación',
            'Cervecería Boliviana Nacional (CBN)',
            'Banco Mercantil Santa Cruz',
            'Entel S.A.',
            'Soboce S.A.',
            'Tigo Bolivia',
            'Farmacorp',
            'Minera San Cristóbal'
        ];

        foreach ($nombresInstituciones as $nombre) {
            $inst = Cliente::factory()->create([
                'nombre' => $nombre,
                'tipo_cliente_id' => $tipoEmpresa->id
            ]);

            Cliente::factory()->count(rand(1, 3))->create([
                'tipo_cliente_id' => $tipoContacto->id,
                'cliente_id' => $inst->id // Auto-referencia
            ]);
        }
    }
}
