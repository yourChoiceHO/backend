<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id_vote');
            //FK
            //$table->unsignedInteger('voter_id');
            //FK
            $table->unsignedInteger('election_id');
            //client existiert noch nicht
            //$table->unsignedInteger('client_id');
            $table->tinyInteger('first_vote');
            $table->tinyInteger('second_vote')->nullable();
            $table->tinyInteger('valid');
            $table->timestamps();



            //Vote belongs to Election
            $table->foreign('election_id')
                ->references('id_election')
                ->on('elections')
                ->onDelete('cascade');

            //Vote belongs to Client
            /*
            $table->foreign('client_id')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade');
            */

            //Vote belongs to Voter
            /*
            $table->foreign('voter_id')
                ->references('id_voter')
                ->on('voters')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
