<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
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
        $clientId= DB::table('clients')->pluck('id_client')->toArray();

        //Kandidat 1
        DB::table('users')->insert([
            'name' => 'Test1 Testico1',
            'client_id' => $faker->randomElement($clientId),
            'username' => 'Test1',
            'password' => hash('sha256','password1'),
            'role' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Test1 Testico2',
            'client_id' => $faker->randomElement($clientId),
            'username' => 'Test2',
            'password' => hash('sha256','password2'),
            'role' => 1
        ]);        DB::table('users')->insert([
        'name' => 'Test1 Testico3',
        'client_id' => $faker->randomElement($clientId),
        'username' => 'Test3',
        'password' => hash('sha256','password3'),
        'role' => 2
    ]);
    }
}
