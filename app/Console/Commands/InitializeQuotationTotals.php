<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cotizacion;

class InitializeQuotationTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cotizaciones:init-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula y actualiza los totales desnormalizados para todas las cotizaciones existentes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cotizaciones = Cotizacion::all();
        $total = $cotizaciones->count();
        
        $this->info("Iniciando actualización de {$total} cotizaciones...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($cotizaciones as $cotizacion) {
            $cotizacion->refreshTotals();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('¡Totales actualizados correctamente!');
    }
}
