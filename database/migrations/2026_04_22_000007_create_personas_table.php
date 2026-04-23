<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('ci_nit')->nullable();
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();
            $table->foreignId('tipo_persona_id')->constrained('tipo_personas');
            $table->foreignId('persona_id')->nullable()->constrained('personas')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
