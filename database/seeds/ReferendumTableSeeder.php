<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReferendumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        //FK
        $ElectionIDs = DB::table('elections')->pluck('id_election')->toArray();

        DB::table('referendums')->insert([
            'text' => 'Darum geht es in diesem Referendum',
            'constituency' => 228,
            'election_id' => $faker->randomElement($ElectionIDs),
            'yes' => 1234,
            'no' => 1285
        ]);
    }
}
