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
            'election_id' => 100,
            'vote' => 20
        ]);
        DB::table('parties')->insert([
            'name' => 'SPD',
            'text' => 'ich bin ein kleiner test text zur SPD',
            'constituency' => 10,
            //FK
            //Alternative:
            // 'election_id' => $faker->randomElement($electionsIDs),
            'election_id' => 100,
            'vote' => 30
        ]);
        DB::table('parties')->insert([
            'name' => 'SPD',
            'text' => 'ich bin ein kleiner test text zur SPD',
            'constituency' => 67,
            //FK
            //Alternative:
            // 'election_id' => $faker->randomElement($electionsIDs),
            'election_id' => 100,
            'vote' => 50
        ]);





        DB::table('parties')->insert([
            'name' => 'CDU',
            'text' => 'ich bin ein kleiner test text zur CDU',
            'constituency' => 4,
            //FK
            //nimm ein beliebiges Element aus dem oben erzeugten Array
            //Möglicherweise gleiche ID gewählt wie bei anderem gleichen Aufruf
            //hier ok, da mehrere Party-Election many to one-Beziehung ist
            'election_id' => 100,
            'vote' => 20
        ]);

        DB::table('parties')->insert([
            'name' => 'CDU',
            'text' => 'ich bin ein kleiner test text zur CDU',
            'constituency' => 2,
            //FK
            //nimm ein beliebiges Element aus dem oben erzeugten Array
            //Möglicherweise gleiche ID gewählt wie bei anderem gleichen Aufruf
            //hier ok, da mehrere Party-Election many to one-Beziehung ist
            'election_id' => 100,
            'vote' => 30
        ]);

        DB::table('parties')->insert([
            'name' => 'CDU',
            'text' => 'ich bin ein kleiner test text zur CDU',
            'constituency' => 55,
            //FK
            //nimm ein beliebiges Element aus dem oben erzeugten Array
            //Möglicherweise gleiche ID gewählt wie bei anderem gleichen Aufruf
            //hier ok, da mehrere Party-Election many to one-Beziehung ist
            'election_id' => 100,
            'vote' => 100
        ]);

        DB::table('parties')->insert([
            'name' => 'CDU',
            'text' => 'ich bin ein kleiner test text zur CDU',
            'constituency' => 1,
            //FK
            //nimm ein beliebiges Element aus dem oben erzeugten Array
            //Möglicherweise gleiche ID gewählt wie bei anderem gleichen Aufruf
            //hier ok, da mehrere Party-Election many to one-Beziehung ist
            'election_id' => 100,
            'vote' => 20
        ]);
    }
}
