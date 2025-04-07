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
        Schema::create('documentos_solicitante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitante_id')->constrained('solicitantes');
            $table->foreignId('documento_id')->constrained('documentos');
            $table->date('fecha_entrega');
            $table->enum('estado', ['Pendiente', 'Recibido', 'Rechazado', 'En Revision', 'Aprobado']);
            $table->boolean('en_revision')->default(false);
            $table->foreignId('revisado_por')->nullable()->constrained('users');
            $table->timestamp('fecha_inicio_revision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_solicitante');
    }
};
