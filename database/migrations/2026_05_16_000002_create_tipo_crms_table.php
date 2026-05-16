<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_crms', function (Blueprint $column) {
            $column->id();
            $column->string('descripcion');
            $column->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_crms');
    }
};
