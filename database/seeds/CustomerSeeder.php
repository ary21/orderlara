<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for($i = 1; $i <= 20; $i++) {
            DB::table('customers')->insert([
              'nama'    => $faker->name,
              'telp'    => $faker->phoneNumber,
              'alamat'  => $faker->address,
              'umur'    => $faker->numberBetween(25,40),
              'id_city' => $faker->numberBetween(1,40),
              'created_at' => date("Y-m-d H:i:s")
            ]);
  
        }
    }
}
