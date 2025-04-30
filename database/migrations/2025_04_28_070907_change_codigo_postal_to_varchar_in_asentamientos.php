<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCodigoPostalToVarcharInAsentamientos extends Migration
{
    public function up()
    {
        Schema::table('asentamientos', function (Blueprint $table) {
            $table->string('codigo_postal', 5)->change();
        });
    }

    public function down()
    {
        Schema::table('asentamientos', function (Blueprint $table) {
            $table->integer('codigo_postal')->change();
        });
    }
}