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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitante_id')->nullable()->constrained('solicitantes');
            $table->date('fecha_registro');
            $table->date('fecha_renovacion');
            $table->enum('estado', ['Activo', 'Inactivo', 'Pendiente Renovacion']);
            $table->text('observaciones')->nullable();
            $table->decimal('pv', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
