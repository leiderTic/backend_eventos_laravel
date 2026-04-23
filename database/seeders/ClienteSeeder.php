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

        // 2. Crear Instituciones y sus Contactos con datos de Bolivia
        $instituciones = Cliente::factory()->count(8)->create([
            'nombre' => fn() => $faker->company(),
            'tipo_cliente_id' => $tipoEmpresa->id
        ]);

        foreach ($instituciones as $inst) {
            Cliente::factory()->count(rand(1, 3))->create([
                'tipo_cliente_id' => $tipoContacto->id,
                'cliente_id' => $inst->id // Auto-referencia
            ]);
        }
    }
}
