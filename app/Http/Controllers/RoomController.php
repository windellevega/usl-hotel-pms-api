<?php

namespace App\Http\Controllers;

use App\Room;
use App\RoomRate;
use App\StatusHistory;
use App\Booking;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        
        //$rooms = Room::all();

        $rooms->load('StatusHistory');

        if($rooms->count() <= 0){
            return response()->json([
                'message' => 'No rooms to show'
            ]);
        }
        
        $rooms->load('RoomRate.Rate');
        $rooms->load('StatusHistory.Status');

        return response()->json($rooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'roomname' => 'required',
            'roomdesc' => 'required',
            'capacity' => 'required',
            'rateids' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $room = new Room();
        $room->room_name = $request->roomname;
        $room->room_description = $request->roomdesc;
        $room->capacity = $request->capacity;

        $room->save();

        $roomid = $room->id;

        foreach($request->rateids as $rateid) {
            $roomrate = new RoomRate();

            $roomrate->room_id = $roomid;
            $roomrate->rate_id = $rateid;
            $roomrate->active = 1;

            $roomrate->save();
        }

        $statushistory = new StatusHistory();
        $statushistory->status_id = 1;
        $statushistory->room_id = $roomid;
        $statushistory->statusdate = Carbon::now();
        $statushistory->remarks = 'Newly added room';

        $statushistory->save();

        return response()->json([
            'message' => 'Room added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::where('id', $id)
                ->get();
        
        if($room->count() <= 0) {
            return response()->json([
                'message' => 'Room not found.'
            ]);
        }

        $room->load('RoomRate');
        $room->load('RoomRate.Rate');
        $room->load('StatusHistory');
        $room->load('StatusHistory.Status');
        return response()->json($room);

    }

    public function showReservationDates($id)
    {
        $resdates = Booking::select('checkin', 'checkout')
                    ->where('room_id', $id)
                    ->where('checkin', '>', Carbon::now())
                    ->get();

        if($resdates->count() <= 0) {
            return response()->json([
                'message' => 'No reservations for this room.'
            ]);
        }

        return response()->json($resdates);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $room = Room::find($id);
        $room->room_name = $request->room_name;
        $room->room_description = $request->room_description;
        $room->capacity = $request->capacity;

        $room->save();

        return response()->json([
            'message' => 'Room information updated successfully.'
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'statusid' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }
        if($request->statusid == 4) {
            /**
             * For status 4 (Occupied)
             */
            //Check if checkin data is within the current day and bookingstatus is reserved
            $booking = Booking::where('room_id', $id)
                        ->where('bookingstatus', 0)
                        ->where('checkin', '>', date('Y-m-d') . ' 00:01')
                        ->where('checkin', '<', date('Y-m-d') . ' 23:59')
                        ->first();
            if(!$booking) {
                return 0;
            }
            $booking->bookingstatus = 1;
            $booking->save();
        }
        else if($request->statusid == 4 || $request->statusid == 5 || $request->statusid == 8) {
            /**
             * For status 4 (Occupied), 5 (Do not disturb) and 6 (Due out)
             */
            //Check if current date is within checkin and checkout period and currently booked
            $booking = Booking::where('room_id', $id)
                        ->where('bookingstatus', 1)
                        ->where('checkin', '<', Carbon::now())
                        ->where('checkout', '>', Carbon::now())
                        ->first();
            if(!$booking) {
                return 0;
            }
        }
        else {
            /**
             * For other statuses
             */
            //Check if room is currently being booked (cannot change status unless checked out)
            $booking = Booking::where('room_id', $id)
                        ->where('bookingstatus', 1)
                        ->first();
            if($booking) {
                return 1;
            }
        }

        $roomstatus = new StatusHistory();

        $roomstatus->status_id = $request->statusid;
        $roomstatus->room_id = $id;
        $roomstatus->statusdate = Carbon::now();
        $roomstatus->remarks = $request->remarks;

        $roomstatus->save();

        return response()->json([
            'message' => 'Room status changed.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
