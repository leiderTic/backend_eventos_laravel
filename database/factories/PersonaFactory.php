<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition(): array
    {
        return [
            'ci_nit' => $this->faker->numerify('#######'),
            'nombre' => $this->faker->name(),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'tipo_persona_id' => 1,
            'persona_id' => null,
        ];
    }
}
