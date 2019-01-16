<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rents')->insert([
            'iduser' => 2,
            'idbooks' => 5,
        ]);
        DB::table('rents')->insert([
            'iduser' => 3,
            'idbooks' => 1,
        ]);
    }
}
