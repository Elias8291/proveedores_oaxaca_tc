<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementTypesTable extends Migration
{
    public function up()
    {
        Schema::create('settlement_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 300);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settlement_types');
    }
}