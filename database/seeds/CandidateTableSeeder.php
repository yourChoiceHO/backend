<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CandidateTableSeeder extends Seeder
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
        $partiesIDs = DB::table('parties')->pluck('id_party')->toArray();

        //Kandidat 1
        DB::table('candidates')->insert([
            'last_name' => 'Westerwelle',
            'first_name' => 'Guido',
            'party_id' => null,
            'constituency' => 6,
            //FK
            //Alternative:
            //'election_id' => \App\Election::first()->id_election,
            //'election_id' => $faker->randomElement($electionsIDs),
            'election_id' =>1,
            'vote' => 2
        ]);

        //Kandidat 2
        DB::table('candidates')->insert([
            'last_name' => 'Merkel',
            'first_name' => 'Angela',
            'party_id' => $faker->randomElement($partiesIDs),
            'constituency' => 1,
            //FK
            //Alternative:
            //'election_id' => \App\Election::first()->id_election,
            //'election_id' => $faker->randomElement($electionsIDs),
            'election_id' =>1,
            'vote' => 5
        ]);
    }
}
