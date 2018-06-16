<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ElectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       /* $faker = Faker::create();
        //hole alle Elemente in Election/id_election
        $clientsIDs = DB::table('clients')->pluck('id_client')->toArray();
        //1
        //noch nicht begonnene Bundestagswahl
        DB::table('elections')->insert([
            'client_id' =>  $faker->randomElement($clientsIDs),
            'typ' => 'Bundestagswahl',
            'text' => 'noch nicht begonnene Bundestagswahl',
            'start_date' => date("Y-m-d H:i:s"),
            'end_date' => date("Y-m-d H:i:s"),
            'state' => 0
        ]);

        DB::table('elections')->insert([
            'typ' => 'Landtagswahl',
            'text' => 'noch nicht begonnene Landtag',
            'start_date' => date("Y-m-d H:i:s"),
            'end_date' => date("Y-m-d H:i:s"),
            'state' => 0
        ]);*/
    }
}
