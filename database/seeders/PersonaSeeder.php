<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Tipos de Persona
        $tipoSocial = TipoPersona::firstOrCreate(['descripcion' => 'Particular (Social)']);
        $tipoEmpresa = TipoPersona::firstOrCreate(['descripcion' => 'Institución / Empresa']);
        $tipoContacto = TipoPersona::firstOrCreate(['descripcion' => 'Persona de Contacto']);

        // 2. Crear Personas Particulares
        Persona::factory()->count(10)->create([
            'tipo_persona_id' => $tipoSocial->id
        ]);

        // 3. Crear Instituciones y sus Contactos
        $instituciones = Persona::factory()->count(5)->create([
            'nombre' => fn() => fake()->company(),
            'tipo_persona_id' => $tipoEmpresa->id
        ]);

        foreach ($instituciones as $inst) {
            Persona::factory()->count(2)->create([
                'tipo_persona_id' => $tipoContacto->id,
                'persona_id' => $inst->id // Auto-referencia
            ]);
        }
    }
}
