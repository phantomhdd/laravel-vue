<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        for ($i = 1; $i <= 11; $i++) {
            // insert data ke table user
            User::insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
