<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Model/Table Party/parties
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //hole alle Elemente in Election/id_election
        $electionsIDs = DB::table('elections')->pluck('id_election')->toArray();

        DB::table('parties')->insert([
            'name' => 'SPD',
            'text' => 'ich bin ein kleiner test text zur SPD',
            'constituency' => 4,
            //FK
            //Alternative:
            // 'election_id' => $faker->randomElement($electionsIDs),
            'election_id' => \App\Election::first()->id_election,
            'vote' => 2
        ]);



        DB::table('parties')->insert([
            'name' => 'CDU',
            'text' => 'ich bin ein kleiner test text zur CDU',
            'constituency' => 4,
            //FK
            //nimm ein beliebiges Element aus dem oben erzeugten Array
            //Möglicherweise gleiche ID gewählt wie bei anderem gleichen Aufruf
            //hier ok, da mehrere Party-Election many to one-Beziehung ist
            'election_id' => $faker->randomElement($electionsIDs),
            'vote' => 8
        ]);
    }
}
