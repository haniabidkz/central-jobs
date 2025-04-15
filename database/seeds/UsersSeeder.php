<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ABC',
            'role' => '2',
            'email' => 'abc@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
