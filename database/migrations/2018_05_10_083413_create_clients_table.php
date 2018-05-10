<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id_client')->primary();//unsigned bigInteger, primary key
            $table->string('typ');//Änderung von tinyInteger zu string lt. Tobin
            $table->timestamps();


//            //FK
//            $table->foreign('x_id')//FK
//                ->references('id_x')//PK
//                ->on('x')//Table
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
