<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tipo_crm_id')->constrained('tipo_crms');
            $table->dateTime('fecha');
            $table->text('descripcion');
            $table->string('resultado')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crms');
    }
};
