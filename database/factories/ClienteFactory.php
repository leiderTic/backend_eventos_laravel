<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\TipoCliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        // Usar localización boliviana
        $faker = \Faker\Factory::create('es_BO');
        
        return [
            'ci_nit' => $faker->numerify('#######'),
            'nombre' => $faker->name(),
            'correo' => $faker->unique()->safeEmail(),
            'telefono' => $faker->phoneNumber(),
            'tipo_cliente_id' => 1,
            'cliente_id' => null,
        ];
    }
}
