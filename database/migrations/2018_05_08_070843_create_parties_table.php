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
            $table->engine = 'InnoDB';
            $table->increments('id_party');
            $table->string('name');
            $table->text('text')->nullable();
            $table->integer('constituency');
            $table->integer('election_id')->unsigned();
            $table->bigInteger('vote');
            $table->timestamps();

            // FK
            //election_id ist FK, referenziert id in elections

            /*$table->foreign('election_id')
                ->references('id_election')
                ->on('elections');*/


            //erlaube Fremdschlüssel
            /*Schema::table('parties', function($table) {
                $table->foreign('election_id')->references('id_election')->on('elections');
            });*/

        });
        Schema::table('parties', function($table) {
                $table->foreign('election_id')->references('id_election')->on('elections');
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
