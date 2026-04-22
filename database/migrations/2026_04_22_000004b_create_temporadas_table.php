<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temporadas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporadas');
    }
};
