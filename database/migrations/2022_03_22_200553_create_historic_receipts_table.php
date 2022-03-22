<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historic_receipts', function (Blueprint $table) {
            $table->id();
            $table->decimal('value_paid');
            $table->unsignedBigInteger('receipt_id');
            $table->foreign('receipt_id')->references('id')->on('receipts');
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
        Schema::dropIfExists('historic_receipts');
    }
}
