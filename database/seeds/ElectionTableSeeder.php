<?php

use Illuminate\Database\Seeder;

class ElectionTableSeeder extends Seeder
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
        $ClientIDs = DB::table('clients')->pluck('id_client')->toArray();

        DB::table('elections')->insert([
            'client_id' => $faker->randomElement($ClientIDs),
            'typ' => 'Landtagswahl',
            'text' => 'Beschreibung der Wahl',
            'start_date' => date("Y-m-d H:i:s"),
            'end_date' => date("Y-m-d H:i:s"),
            'state' => 1
        ]);

    }
}
