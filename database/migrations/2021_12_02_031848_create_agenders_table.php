<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('hour');
            $table->time('hourEnd')->nullable();
        // $table->foreignId('protocol_id')->constrained();
            // $table->string('protocols_id');
            $table->unsignedBigInteger('doctor_id');
            $table->foreignId('patient_id')->constrained();
            $table->foreign('doctor_id')->references('id')->on('users');
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
        Schema::dropIfExists('agenders');
    }
}
