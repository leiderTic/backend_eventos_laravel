<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reuniones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->date('fecha');
            $table->string('hora');
            $table->foreignId('modalidad_id')->constrained('modalidades');
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('Programada'); // Programada, Realizada, Cancelada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reuniones');
    }
};
