<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'statustype' => 'Vacant Ready',
                'abbreviation' => 'VR'
            ],
            [
                'statustype' => 'Vacant Clean',
                'abbreviation' => 'VC'
            ],
            [
                'statustype' => 'Vacant Dirty',
                'abbreviation' => 'VD'
            ],
            [
                'statustype' => 'Occupied',
                'abbreviation' => 'OCC'
            ],
            [
                'statustype' => 'Do not Disturb',
                'abbreviation' => 'DND'
            ],
            [
                'statustype' => 'Out of Order',
                'abbreviation' => 'OOO'
            ],
            [
                'statustype' => 'No Show',
                'abbreviation' => 'NS'
            ],
            [
                'statustype' => 'Due Out',
                'abbreviation' => 'DO'
            ]
        ];

        DB::table('statuses')->insert($statuses);
    }
}
