<?php

namespace App\Http\Controllers;

use App\Room;
use App\RoomRate;

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
        //
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
            $roomrates = new RoomRate();

            $roomrate->room_id = $room->id;
            $roomrate->rate_id = $rateid;
            $roomrate->active = 1;

            $roomrate->save();
        }

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
        //
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
