<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //12 titles
        for ($i = 0; $i < 12; $i++) {
            //count of title
            $count=($i % 3) + 1;
            for ($e = 0; $e < $count; $e++) {
                DB::table('books')->insert([
                    'idtitles' => $i + 1,
                ]);
            }
        }
    }
}
