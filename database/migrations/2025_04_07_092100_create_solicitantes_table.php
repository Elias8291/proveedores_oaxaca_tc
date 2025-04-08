<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('email', 255);
            $table->string('telefono', 255)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->string('razon_social', 255);
            $table->enum('tipo_persona', ['Fisica', 'Moral']);
            $table->string('curp', 255)->nullable();
            $table->foreignId('direccion_id')->nullable()->constrained('direcciones');
            $table->foreignId('contacto_id')->nullable()->constrained('contactos_solicitante');
            $table->foreignId('representante_legal_id')->nullable()->constrained('representantes_legales');
            $table->foreignId('dato_constitutivo_id')->nullable()->constrained('datos_constitutivos');
            $table->enum('estado_revision', ['Pendiente', 'En Revision', 'Revisado'])->default('Pendiente');
            $table->unsignedTinyInteger('progreso_tramite')->default(0);
            $table->unsignedTinyInteger('numero_seccion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};