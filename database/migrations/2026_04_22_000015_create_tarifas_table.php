<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio_dia', 10, 2);
            $table->foreignId('tipo_tarifa_id')->constrained('tipo_tarifas');
            $table->foreignId('temporada_id')->constrained('temporadas');
            $table->foreignId('espacio_id')->constrained('espacios')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
