<?php

use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            [
                'grouprate' => 1300.00,
                'solorate' => 500.00,
                'ratedescription' => 'Good for four persons'
            ],
            [
                'grouprate' => 850.00,
                'solorate' => 500.00,
                'ratedescription' => 'Good for one to two persons'
            ],
            [
                'grouprate' => 1300.00,
                'solorate' => 500.00,
                'ratedescription' => 'Good for two to four persons'
            ],
            [
                'grouprate' => 2000.00,
                'solorate' => 400.00,
                'ratedescription' => 'Good for four to eight persons'
            ],
            [
                'grouprate' => 1000.00,
                'solorate' => 600.00,
                'ratedescription' => 'Good for one to two persons'
            ],
            [
                'grouprate' => null,
                'solorate' => 200.00,
                'ratedescription' => 'Wash Up'
            ],
            [
                'grouprate' => null,
                'solorate' => 300.00,
                'ratedescription' => 'Half Day Use'
            ],
            [
                'grouprate' => null,
                'solorate' => 400.00,
                'ratedescription' => 'Day Use'
            ],
            [
                'grouprate' => 3675.00,
                'solorate' => 2450.00,
                'ratedescription' => 'One Week'
            ],
            [
                'grouprate' => 4750.00,
                'solorate' => 3185.00,
                'ratedescription' => 'Two Weeks'
            ],
            [
                'grouprate' => 6150.00,
                'solorate' => 4100.00,
                'ratedescription' => 'Three Weeks'
            ],
            [
                'grouprate' => 7950.00,
                'solorate' => 5300.00,
                'ratedescription' => 'Monthly'
            ]
        ];

        DB::table('rates')->insert($rates);
    }
}
