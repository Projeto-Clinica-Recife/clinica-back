<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgenderProtocol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agender_protocols', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['waiting','finished', 'canceled'])->default('waiting');
            $table->foreignId('agender_id')->constrained();
            $table->foreignId('protocol_id')->constrained();
            $table->decimal('value');
            $table->enum('payment_status',['paid' ,'pending']);
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
        Schema::dropIfExists('agender_protocols');
    }
}
