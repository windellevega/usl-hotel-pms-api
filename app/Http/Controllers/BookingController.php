<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\Billing;

class BookingController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'checkin' => 'required',
            'numpax' => 'required | numeric',
            'guestid' => 'required',
            'roomid' => 'required',
            'bookingtypeid' => 'required',
            'bookingcharge' => 'numeric',
            'downpayment' => 'numeric'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $booking = new Booking();

        $booking->checkin = $request->checkin;
        $booking->checkout = $request->checkout;
        $booking->numberofpax = $request->numpax;
        $booking->remarks = $request->remarks;
        $booking->guest_id = $request->guestid;
        $booking->room_id = $request->room_id;
        //$booking->booked_by = Auth::id();
        $booking->bookingtype_id = $request->bookingtypeid;
        $booking->bookingcharge = $request->bookingcharge;

        $booking->save();

        $billing = new Billing();
        $billing->booking_id = $booking->id;
        $billing->downpayment = $request->downpayment;

        $billing->save();

        return response()->json([
            'message' => 'Booking added successfully.'
        ]);
    }

    public function reserve(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'checkin' => 'required',
            'checkout' => 'required',
            'numpax' => 'required | numeric',
            'guestid' => 'required',
            'roomid' => 'required',
            'bookingtypeid' => 'required',
            'bookingcharge' => 'numeric',
            'downpayment' => 'numeric',
            'resdate' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $reservation = new Booking();

        $reservation->checkin = $request->checkin;
        $reservation->checkout = $request->checkout;
        $reservation->numberofpax = $request->numpax;
        $reservation->remarks = $request->remarks;
        $reservation->reservationstatus = 0;
        $reservation->reservationdate = $request->resdate;
        $reservation->guest_id = $request->guestid;
        $reservation->room_id = $request->room_id;
        //$reservation->booked_by = Auth::id();
        $reservation->bookingtype_id = $request->bookingtypeid;
        $reservation->bookingcharge = $request->bookingcharge;

        $reservation->save();

        $billing = new Billing();
        $billing->booking_id = $reservation->id;
        $billing->downpayment = $request->downpayment;

        $billing->save();

        return response()->json([
            'message' => 'Reservation added successfully.'
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
        //
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
