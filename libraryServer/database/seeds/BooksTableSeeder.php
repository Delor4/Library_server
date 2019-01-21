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
        $names = [
            0 => ['Podstawy','Wstep do','Biblia'],
            1 => ['programowania','algorytmiki', 'hackowania', 'baz danych'],
        ];
        for ($i = 0; $i < count($names[0]); $i++) {
            for ($j = 0; $j < count($names[1]); $j++) {
                DB::table('titles')->insert([
                    'title' => $names[0][$i] . ' ' . $names[1][$j].'.',
                ]);
            }
        }
    }
}
