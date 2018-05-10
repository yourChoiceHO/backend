<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id_candidate');
            $table->string('last_name');
            $table->string('first_name');
            //FK
            $table->unsignedInteger('party_id')->nullable();
            $table->integer('constituency');
            //FK
            $table->unsignedInteger('election_id');
            $table->bigInteger('vote');
            $table->timestamps();




            //Candidate may be belongs to Party
            $table->foreign('party_id')
                ->references('id_party')
                ->on('parties')
                ->onDelete('cascade');

            //Candidate belongs to Election
            $table->foreign('election_id')
                ->references('id_election')
                ->on('elections')
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
        Schema::dropIfExists('candidates');
    }
}
