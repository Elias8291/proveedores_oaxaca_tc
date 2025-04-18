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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_postal');
            $table->foreignId('asentamiento_id')->nullable()->constrained('asentamientos');
            $table->string('calle', 255)->nullable();
            $table->string('numero_exterior', 255)->nullable();
            $table->string('numero_interior', 255)->nullable();
            $table->string('entre_calle_1', 255)->nullable();
            $table->string('entre_calle_2', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};