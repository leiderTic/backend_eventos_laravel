<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('porcentajes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('porcentaje');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('porcentajes');
    }
};
