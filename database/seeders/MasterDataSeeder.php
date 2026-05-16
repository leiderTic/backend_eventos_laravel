<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banco;
use App\Models\TipoRespaldo;
use App\Models\Porcentaje;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Bancos
        $bancos = ['Banco Unión', 'BNB', 'Banco Sol', 'Banco Mercantil Santa Cruz'];
        foreach ($bancos as $banco) {
            Banco::create(['nombre' => $banco]);
        }

        // Tipo de Respaldos
        $tipos = [
            'Aceptación por Correo',
            'Carta de Compromiso',
            'Contrato Digital Firmado'
        ];
        foreach ($tipos as $tipo) {
            TipoRespaldo::create(['descripcion' => $tipo]);
        }

        // Porcentajes
        $porcentajes = [
            ['descripcion' => 'Anticipo Reserva', 'porcentaje' => 20],
            ['descripcion' => 'Saldo Pendiente', 'porcentaje' => 80],
            ['descripcion' => 'Pago Total', 'porcentaje' => 100],
        ];
        foreach ($porcentajes as $p) {
            Porcentaje::create($p);
        }
    }
}
