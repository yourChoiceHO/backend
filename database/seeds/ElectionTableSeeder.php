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

        //\App\Party::something
        DB::table('elections')->insert([
            'typ' => 'Bundestagswahl',
            'text' => 'ich bin ein kleiner test text zur bundestagswahl',
            'start_date' => date("Y-m-d H:i:s"),
            'end_date' => date("Y-m-d H:i:s"),
            'state' => 2
        ]);

        DB::table('elections')->insert([
            'typ' => 'Landtagswahl',
            'text' => 'ich bin ein kleiner test text zur Landtagswahl',
            'start_date' => date("Y-m-d H:i:s"),
            'end_date' => date("Y-m-d H:i:s"),
            'state' => 1
        ]);
    }
}
