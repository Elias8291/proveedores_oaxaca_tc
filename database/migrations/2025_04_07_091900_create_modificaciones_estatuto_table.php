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
        Schema::create('modificaciones_estatuto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dato_constitutivo_id')->constrained('datos_constitutivos');
            $table->string('numero_escritura', 255);
            $table->date('fecha_modificacion');
            $table->string('nombre_notario', 255);
            $table->foreignId('estado_id')->constrained('estados');
            $table->string('numero_notario', 255);
            $table->string('registro_mercantil', 255);
            $table->date('fecha_registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modificaciones_estatuto');
    }
};
