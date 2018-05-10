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

            $table->bigIncrements('id_election');//unsigned bigInteger, primary key
            $table->bigInteger('client_id');
            $table->string('typ');
            $table->string('text')->nullable();//oder anstatt string besser text
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->tinyInteger('state');
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
        Schema::dropIfExists('elections');
    }
}
