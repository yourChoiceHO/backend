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
            //PK_part1
            $table->unsignedInteger('voter_id');
            //PK_part2
            $table->unsignedInteger('election_id');
            //client existiert noch nicht
            //$table->unsignedInteger('client_id');
            //TinyInt = 0/1
            $table->tinyInteger('first_vote');
            $table->tinyInteger('second_vote')->nullable();
            $table->tinyInteger('valid');
            $table->timestamps();
            $table->primary(['voter_id', 'election_id']);
            //trotz composite Pk noch nötig?
            /*
            //Vote belongs to Election
            $table->foreign('election_id')
                ->references('id_election')
                ->on('elections')
                ->onDelete('cascade');
            */
            //Vote belongs to Client
            /*
            $table->foreign('client_id')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade');
            */
            //trotz composite Pk noch nötig?
            /*
            //Vote belongs to Voter
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
