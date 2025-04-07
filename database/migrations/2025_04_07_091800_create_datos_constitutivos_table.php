<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('datos_constitutivos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_escritura', 255);
            $table->date('fecha_constitucion');
            $table->string('nombre_notario', 255);
            $table->foreignId('estado_id')->constrained('estados');
            $table->string('numero_notario', 255);
            $table->string('registro_mercantil', 255);
            $table->date('fecha_registro');
            $table->text('objeto_social');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_constitutivos');
    }
};
