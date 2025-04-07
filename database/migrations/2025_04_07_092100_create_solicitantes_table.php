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
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('email', 255)->nullable();
            $table->string('telefono', 255)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->string('rfc', 255)->unique();
            $table->string('razon_social', 255);
            $table->enum('tipo_persona', ['Fisica', 'Moral']);
            $table->string('curp', 255)->nullable();
            $table->foreignId('direccion_id')->constrained('direcciones');
            $table->foreignId('contacto_id')->nullable()->constrained('contactos_solicitante');
            $table->foreignId('representante_legal_id')->nullable()->constrained('representantes_legales');
            $table->foreignId('dato_constitutivo_id')->nullable()->constrained('datos_constitutivos');
            $table->enum('estado_revision', ['Pendiente', 'En Revision', 'Revisado'])->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};
