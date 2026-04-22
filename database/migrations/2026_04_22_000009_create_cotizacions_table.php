<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("cotizaciones", function (Blueprint $table) {
            $table->id();
            $table->text("descripcion")->nullable();
            $table->date("fecha_ini");
            $table->date("fecha_fin");
            $table->integer("paso")->default(1);
            $table->boolean("vencido")->default(false);
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("evento_id")->constrained("eventos");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("cotizaciones");
    }
};
