<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Yulidar Maulana I S',
            'username' => 'yulidarmaulana',
            'password' => bcrypt('password'),
            'email' => 'maulanayulidar@gmail.com',
        ]);
    }
}
