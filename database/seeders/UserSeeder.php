<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(1)->create([
            'email' => 'ernandesrsouza@gmail.com',
            'first_name' => 'Ernandes',
            'last_name' => 'Souza',
            'password' => Hash::make("ernandes"),
        ]);

        \App\Models\User::factory(10)->create();
    }
}
