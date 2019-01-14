<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //librarian
        DB::table('users')->insert([
            'name' => 'bibl',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 1,
        ]);
        //first user
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 2,
        ]);
        //rest of users
        for ($i = 0; $i < 8; $i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
                'role' => 2,
            ]);
        }
    }
}
