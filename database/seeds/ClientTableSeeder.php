<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = Faker::create();

        //FK
//        $fkIDs = DB::table('tablefk')->pluck('id_fk')->toArray();
        //bei insert 'pk_id' => $faker->randomElement($fkIDs),


        DB::table('clients')->insert([
            'typ' => 'Bundestag'
        ]);
        DB::table('clients')->insert([
            'typ' => 'Landtag'
        ]);
        DB::table('clients')->insert([
            'typ' => 'Landtag'
        ]);
        DB::table('clients')->insert([
            'typ' => 'Bundestag'
        ]);
    }
}
