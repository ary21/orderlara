<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for($i = 1; $i <= 50; $i++) {
            DB::table('citys')->insert(['city' => $faker->city, 'created_at' => date("Y-m-d H:i:s")]);
        }

    }
}
