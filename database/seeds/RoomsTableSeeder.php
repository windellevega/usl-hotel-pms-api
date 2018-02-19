<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Room;
use App\RoomRate;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                'room_name' => 'Room 201',
                'room_description' => 'Single Room with Four Single Beds (good for four persons)',
                'capacity' => 4,
                'roomrates' => [
                    ['rate_id' => 1],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
                ],
            [
                'room_name' => 'Room 202',
                'room_description' => 'Single Room with One Twin/Double Bed(good for one to two persons)',
                'capacity' => 2,
                'roomrates' => [
                    ['rate_id' => 2],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
            ],
            [
                'room_name' => 'Room 203',
                'room_description' => 'Single Room with Two Twin/Double Beds (good for two to four persons)',
                'capacity' => 4,
                'roomrates' => [
                    ['rate_id' => 3],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
            ],
            [
                'room_name' => 'Room 301',
                'room_description' => 'Dormitory Rooms with Four Bunk Beds (good for four to eight persons)',
                'capacity' => 8,
                'roomrates' => [
                    ['rate_id' => 4],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
            ],
            [
                'room_name' => 'Room 302',
                'room_description' => 'Dormitory Rooms with Four Bunk Beds (good for four to eight persons)',
                'capacity' => 8,
                'roomrates' => [
                    ['rate_id' => 4],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
            ],
            [
                'room_name' => 'Room 303',
                'room_description' => 'Single Room with One Double Bed and Fully Equipped Kitchennette',
                'capacity' => 2,
                'roomrates' => [
                    ['rate_id' => 5],
                    ['rate_id' => 6],
                    ['rate_id' => 7],
                    ['rate_id' => 8],
                    ['rate_id' => 9],
                    ['rate_id' => 10],
                    ['rate_id' => 11],
                ]
            ]
        ];

        $rooms = json_encode($rooms);
        $rooms = json_decode($rooms);

        foreach($rooms as $r) {
            $room = new Room();
            $room->room_name = $r->room_name;
            $room->room_description = $r->room_description;
            $room->capacity = $r->capacity;

            $room->save();

            $rid = $room->id;

            foreach($r->roomrates as $rr) {
                $roomrate = new RoomRate();
                $roomrate->room_id = $rid;
                $roomrate->rate_id = $rr->rate_id;
                $roomrate->active = 1;

                $roomrate->save();
            }
        }
    }
}
