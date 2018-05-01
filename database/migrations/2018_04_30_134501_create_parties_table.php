<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id_party');
            $table->string('name')->unique();
            $table->text('text')->nullable();
            $table->integer('consituency');
            $table->unsignedInteger('election_id');
            $table->bigInteger('vote');
            $table->timestamps();

            // FK ------> FEHLER
            //election_id ist FK, referenziert id in elections

            $table->foreign('election_id')
                ->references('id_election')
                ->on('elections')
                ->onDelete('cascade');


            //erlaube Fremdschlüssel
            Schema::enableForeignKeyConstraints();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parties');
    }
}
