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
        $voterIDs = DB::table('voters')->pluck('id_voter')->toArray();

        DB::table('votes')->insert([
            'voter_id' => $faker->randomElement($voterIDs),
            'election_id' => $faker->randomElement($electionsIDs),
            'first_vote' => '1',
            'second_vote' => '1',
            'valid'=> 0
        ]);
    }
}
