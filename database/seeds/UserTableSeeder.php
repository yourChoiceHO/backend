<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    const ADMIN = 0;
    const MODERATOR = 2;
    const SUPERVISOR = 1;
    const VOTER = 3;

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //hole alle Elemente in Election/id_election
        $clientId = DB::table('clients')->pluck('id_client')->toArray();

        $id1 = $faker->randomElement($clientId);
        DB::table('users')->insert([
            'name' => 'Test1 Testico1',
            'client_id' => $id1,
            'username' => 'Test1',
            'password' => hash('sha256', 'password1'),
            'role' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Test1 Testico2',
            'client_id' => $id1,
            'username' => 'Test2',
            'password' => hash('sha256', 'password2'),
            'role' => 2
        ]);

        while(($id2 = $faker->randomElement($clientId)) == $id1);

        DB::table('users')->insert([
            'name' => 'Test1 Testico3',
            'client_id' => $id2,
            'username' => 'Test3',
            'password' => hash('sha256', 'password3'),
            'role' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Test1 Testico4',
            'client_id' => $id2,
            'username' => 'Test4',
            'password' => hash('sha256', 'password4'),
            'role' => 2
        ]);
    }
}
