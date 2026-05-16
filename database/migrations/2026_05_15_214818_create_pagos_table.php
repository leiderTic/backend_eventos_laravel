<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_pagado', 12, 2);
            $table->date('fecha_deposito');
            $table->string('nro_comprobante');
            $table->string('boucher_path');
            $table->foreignId('banco_id')->constrained('bancos');
            $table->enum('estado', ['pendiente', 'verificado', 'rechazado'])->default('pendiente');
            $table->foreignId('verificado_por')->nullable()->constrained('users');
            $table->dateTime('fecha_verificacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            
            $table->unique(['nro_comprobante', 'banco_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
