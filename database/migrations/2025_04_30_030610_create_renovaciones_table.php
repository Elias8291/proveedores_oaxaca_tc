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
        Schema::create('renovaciones', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor_pv', 10); 
            $table->date('fecha_renovacion');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('estado', 20)->default('Pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->foreign('proveedor_pv')->references('pv')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renovaciones');
    }
};