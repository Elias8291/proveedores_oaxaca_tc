<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name');
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('rfc')->unique();
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}