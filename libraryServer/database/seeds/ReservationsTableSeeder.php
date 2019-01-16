<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->insert([
            'iduser' => 2,
            'idtitles' => 1,
        ]);
        DB::table('reservations')->insert([
            'iduser' => 2,
            'idtitles' => 5,
        ]);
        DB::table('reservations')->insert([
            'iduser' => 6,
            'idtitles' => 1,
        ]);
        DB::table('reservations')->insert([
            'iduser' => 3,
            'idtitles' => 6,
        ]);
    }
}
