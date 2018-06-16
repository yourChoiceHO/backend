<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VoterTableSeeder extends Seeder
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
        $electionsIDs = DB::table('elections')->pluck('id_election')->toArray();

        DB::table('voters')->insert([
            'last_name' => 'Wurst',
            'first_name' => 'Hans',
            'hash' => 'hsg65r65raghdvhgadhgav',
            'constituency' => 4
        ]);*/
    }
}
