<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Booking;
use App\Billing;
use App\Room;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBookings()
    {
        $bookings = Booking::all()
                    ->sortByDesc('checkin');
        $bookings->load('Room');
        $bookings->load('Guest');
        $bookings->load('BookingType');
        $bookings->load('User');

        if($bookings->count() <= 0) {
            return response()->json([
                'message' => 'No bookings to display.'
            ]);
        }

        return response()->json($bookings);
    }

    public function showReservations()
    {
        $reservations = Booking::whereNotNull('reservationdate')
                            ->where('checkin', '>=', Carbon::now())
                            ->orderBy('checkin')
                            ->get();
        $reservations->load('Room');
        $reservations->load('Guest');
        $reservations->load('BookingType');
        $reservations->load('User');

        if($reservations->count() <= 0) {
            return response()->json([
                'message' => 'No reservations to display.'
            ]);
        }

        return response()->json($reservations);
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

        $booking->checkin = Carbon::now();
        $booking->checkout = $request->checkout;
        $booking->numberofpax = $request->numpax;
        $booking->remarks = $request->remarks;
        $booking->guest_id = $request->guestid;
        $booking->room_id = $request->roomid;
        $booking->booked_by = 1;//Auth::id();
        $booking->bookingtype_id = $request->bookingtypeid;
        $booking->bookingcharge = $request->bookingcharge;

        $booking->save();

        $billing = new Billing();
        $billing->booking_id = $booking->id;
        $billing->downpayment = $request->downpayment;
        $billing->totalcharges = $request->bookingcharge;

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
        $reservation->room_id = $request->roomid;
        $reservation->booked_by = 1;//Auth::id();
        $reservation->bookingtype_id = $request->bookingtypeid;
        $reservation->bookingcharge = $request->bookingcharge;

        $reservation->save();

        $billing = new Billing();
        $billing->booking_id = $reservation->id;
        $billing->downpayment = $request->downpayment;
        $billing->totalcharges = $request->bookingcharge;

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
        $booking = Booking::where('id', $id)
                    ->get();
        $booking->load('BookingType');
        $booking->load('Room');
        $booking->load('Billing');
        $booking->load('Billing.OtherCharge');
        $booking->load('Guest');
        $booking->load('Guest.GuestType');
        $booking->load('Guest.Company');

        if($booking->count() != 0) {
            return response()->json($booking);
        }
        else {
            return response()->json([
                'message' => "This booking doesn't exist"
            ]);
        }
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
        //Todo!
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
