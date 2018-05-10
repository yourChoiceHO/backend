<?php

use Illuminate\Database\Seeder;

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
        $ElectionIDs = DB::table('elections')->pluck('id_elections')->toArray();

        DB::table('elections')->insert([
            'text' => 'Darum geht es in diesem Referendum',
            'consistuency' => '228',
            'election_id' => $faker->randomElement($ElectionIDs),
            'yes' => '1234',
            'no' => '1285'
        ]);
    }
}
