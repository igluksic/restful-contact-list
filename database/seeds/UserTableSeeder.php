<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'Igor',
            'email'=> 'igluksic@gmail.com',
            'password'=> app('hash')->make('123456')]);
    }
}