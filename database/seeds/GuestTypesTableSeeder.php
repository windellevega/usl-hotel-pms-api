<?php

use Illuminate\Database\Seeder;

class GuestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guesttypes = [
            [
                'guesttype' => 'Grad School Professor'
            ],
            [
                'guesttype' => 'Visiting Professor'
            ],
            [
                'guesttype' => 'Visitor'
            ]
        ];
        
        DB::table('guest_types')->insert($guesttypes);
    }
}
