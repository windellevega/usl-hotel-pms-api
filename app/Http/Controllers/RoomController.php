<?php

namespace App\Http\Controllers;

use App\Room;
use App\RoomRate;
use App\StatusHistory;

use Carbon\Carbon;

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
        $rooms = Room::with(['StatusHistory' => function($query) {
                    $query->orderBy('id', 'DESC')->first();
                }])->get();

        if($rooms->count() <= 0){
            return response()->json([
                'message' => 'No rooms to show'
            ]);
        }
        
        $rooms->load('RoomRate');
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
        $room->room_name = isset($request->roomname) ? $request->roomname : $room->room_name;
        $room->room_description = isset($request->roomname) ? $request->roomdesc : $room->room_description;
        $room->capacity = isset($request->capacity) ? $request->capacity : $room->capacity;

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
