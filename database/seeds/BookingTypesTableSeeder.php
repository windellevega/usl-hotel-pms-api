<?php

use Illuminate\Database\Seeder;

class BookingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookingtypes = [
            [
                'bookingtype' => 'Regular',
            ],
            [
                'bookingtype' => 'Wash Up',
            ],
            [
                'bookingtype' => 'Half Day Use',
            ],
            [
                'bookingtype' => 'Day Use',
            ]
        ];

        DB::table('booking_types')->insert($bookingtypes);
    }
}
