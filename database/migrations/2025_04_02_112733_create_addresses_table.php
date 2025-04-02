<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('settlement_id');
            $table->string('street');
            $table->string('external_number');
            $table->string('internal_number')->nullable();
            $table->string('between_street_1')->nullable();
            $table->string('between_street_2')->nullable();
            $table->timestamps();

            $table->foreign('settlement_id')->references('id')->on('settlements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}