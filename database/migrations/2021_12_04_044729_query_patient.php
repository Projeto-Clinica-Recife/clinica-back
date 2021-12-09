<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QueryPatient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_patients', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreignId('patient_id')->constrained();
            $table->unsignedBigInteger('agender_protocol_id');
            $table->foreign('agender_protocol_id')->references('id')->on('agender_protocols');
            $table->string('plaint'); //queixa
            $table->string('observation'); //observações
            $table->text('protocols'); //protocolos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('query_patient');
    }
}
