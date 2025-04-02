<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadesTable extends Migration
{
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('municipality_id');
            $table->string('name', 370);
            $table->timestamps();

            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}