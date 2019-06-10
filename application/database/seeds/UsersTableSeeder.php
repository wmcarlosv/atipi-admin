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
        DB::table('users')->insert([
        	'name' => 'Carlos Vargas',
        	'email' => 'cvargas@frontuari.net',
        	'phone' => '+584160984343',
        	'country_id' => 1,
        	'role' => 'administrator',
        	'password' => bcrypt('Car2244los*'),
        	'status' => 'active'
        ]);
    }
}
