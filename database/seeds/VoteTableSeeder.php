<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //hole alle Elemente in Election/id_election
        $electionsIDs = DB::table('elections')->pluck('id_election')->toArray();

        DB::table('votes')->insert([
            'election_id' => $faker->randomElement($electionsIDs),
            'first_vote' => '1',
            'second_vote' => null,
            'valid'=> 0
        ]);
    }
}
