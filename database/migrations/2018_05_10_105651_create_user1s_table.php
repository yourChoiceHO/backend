<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user1s', function (Blueprint $table) {
            $table->bigIncrements('id_user')->primary();//unsigned bigInteger, primary key
            $table->bigInteger('client_id');
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('role');
            $table->timestamps();

            //FK
            $table->foreign('client_id')//FK
                ->references('id_client')//PK
                ->on('clients')//Table
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user1s');
    }
}
