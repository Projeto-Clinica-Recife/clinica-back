<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->enum('type_user', ['admin', 'doctor', 'reception']);
            $table->boolean('first_access')->default(true);
            $table->string('password');
            $table->softDeletes();
            // $table->rememberToken();
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
        Schema::dropIfExists('users', function(Blueprint $table){
            // $table->foreignId('type_user_id')
            // ->constrained()
            // ->onDelete('cascade');
        });
    }
}
