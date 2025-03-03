<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            BooksTableSeeder::class,
            CatalogTableSeeder::class,
            ReservationsTableSeeder::class,
            RentsTableSeeder::class,
            LogTableSeeder::class
        ]);
    }
}
