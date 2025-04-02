<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_id')->unique()->nullable();
            $table->string('business_name');
            $table->enum('person_type', ['Individual', 'Legal']);
            $table->string('curp')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->enum('review_status', ['Pending', 'In Review', 'Reviewed'])->default('Pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}