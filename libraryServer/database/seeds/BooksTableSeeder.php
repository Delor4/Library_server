<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('titles')->insert([
                'title' => strtoupper(str_random(1)).str_random(10).' '.str_random(10).'.',
            ]);
        }
    }
}
