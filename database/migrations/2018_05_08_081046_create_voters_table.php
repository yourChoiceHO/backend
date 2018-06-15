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
            $table->string('last_name');
            $table->string('first_name');
            $table->string('hash');
            $table->string('password');
            $table->integer('constituency');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('election_id');
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade');

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
        Schema::dropIfExists('voters');
    }
}
