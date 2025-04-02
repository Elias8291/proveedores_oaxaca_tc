<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 405);
            $table->integer('postal_code');
            $table->unsignedBigInteger('localidad_id');
            $table->unsignedBigInteger('settlement_type_id');
            $table->timestamps();

            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('cascade');
            $table->foreign('settlement_type_id')->references('id')->on('settlement_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('settlements');
    }
}