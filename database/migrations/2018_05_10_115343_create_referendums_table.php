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
            $table->integer('election_id')->unsigned()->nullable();
            $table->bigInteger('yes');
            $table->bigInteger('no');
            $table->timestamps();

            //FK
            $table->foreign('election_id')//FK
            ->references('id_election')//PK
            ->on('elections')//Table
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
