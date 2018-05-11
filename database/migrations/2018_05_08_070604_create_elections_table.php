<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            //increments ist unsigned int,
            $table->increments('id_election');

            //muss unsigned da id increments unsigned int ist
            //$table->unsignedInteger('client_id');

            $table->string('typ');
            $table->text('text')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            //TinyInt = 0/1
            $table->tinyInteger('state');
            $table->timestamps();

            //FK
            //client existiert noch nicht
            //$table->foreign('client_id')->references('id_client')->on('client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elections');
    }
}
