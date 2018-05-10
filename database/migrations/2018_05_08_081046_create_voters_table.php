<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->increments('id_voter');
            //noch nicht klar
            //FK
            //$table->unsignedInteger('vote_id');
            $table->string('last_name');
            $table->string('first_name');
            //Fingerprint ist alt, neu vermutlich userID
            //$table->string('finger_print');
            $table->string('userID');
            $table->integer('constituency');
            $table->timestamps();

            //noch nicht klar
            //Voter belongs to Vote
            /*
            $table->foreign('vote_id')
                ->references('id_vote')
                ->on('votes')
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
        Schema::dropIfExists('voters');
    }
}
