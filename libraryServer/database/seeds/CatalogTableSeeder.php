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
        //10 titles
        for ($i = 0; $i < 10; $i++) {
            //count of title
            $count=array_random([1, 2, 3]);
            for ($e = 0; $e < $count; $e++) {
                DB::table('catalog')->insert([
                    'idbooks' => $i,
                ]);
            }
        }
    }
}
