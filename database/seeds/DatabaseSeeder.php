<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GuestTypesTableSeeder::class);
        $this->call(BookingTypesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(RatesTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
    }
}
