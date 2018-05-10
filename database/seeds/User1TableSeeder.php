<?php

use Illuminate\Database\Seeder;

class User1TableSeeder extends Seeder
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
       // bei insert 'pk_id' => $faker->randomElement($fkIDs),


        DB::table('users')->insert([
            'client_id' => $faker->randomElement($ClientIDs),
            'username' => 'hansmaier',
            'password' => 'gh7895',
            'role' => '1',
        ]);
    }
}
