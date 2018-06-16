<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferendumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referendums', function (Blueprint $table) {
            $table->increments('id_referendum');//unsigned bigInteger, primary key
            $table->string('text');
            $table->integer('constituency');
            $table->unsignedInteger('election_id');
            $table->unsignedInteger('client_id');
            $table->bigInteger('yes');
            $table->bigInteger('no');
            $table->timestamps();

            //FK
            $table->foreign('election_id')//FK
            ->references('id_election')//PK
            ->on('elections')//Table
            ->onDelete('cascade');

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
        Schema::dropIfExists('referendums');
    }
}
