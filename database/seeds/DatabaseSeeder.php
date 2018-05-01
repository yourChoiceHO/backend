<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Reihenfolge unbedingt beachten -> Constraints
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ClientTableSeeder::class,
            ElectionTableSeeder::class,
            ReferendumTableSeeder::class
            ElectionTableSeeder::class,
            PartyTableSeeder::class,
        ]);
    }
}
