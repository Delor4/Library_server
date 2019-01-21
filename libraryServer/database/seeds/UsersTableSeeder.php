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
            'email' => 'bibl@bibl.com',
            'password' => bcrypt('secret'),
            'librarian' => 1,
        ]);
        //first user
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user@user.com',
            'password' => bcrypt('secret'),
            'librarian' => 0,
        ]);
        //rest of users
        for ($i = 0; $i < 8; $i++) {
            DB::table('users')->insert([
                'name' => 'user' . ($i + 2),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
            ]);
        }
    }
}
