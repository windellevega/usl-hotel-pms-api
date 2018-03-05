<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Booking;
use App\BookingType;
use App\Billing;
use App\Room;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookings()
    {
        $bookings = Booking::all()
                    ->sortByDesc('checkin');
        $bookings->load('Room');
        $bookings->load('Guest.GuestType');
        $bookings->load('Guest.Company');
        $bookings->load('BookingType');
        $bookings->load('User');
        $bookings->load('Billing');

        if($bookings->count() <= 0) {
            return response()->json([
                'message' => 'There are no bookings to show.'
            ]);
        }

        return response()->json($bookings);
    }

    public function getReservations()
    {
        $reservations = Booking::whereNotNull('reservationdate')
                            ->where('checkin', '>=', Carbon::now())
                            ->orderBy('checkin')
                            ->get();
        $reservations->load('Room');
        $reservations->load('Guest.GuestType','Guest.Company');
        $reservations->load('BookingType');
        $reservations->load('User');
        $reservations->load('Billing');

        if($reservations->count() <= 0) {
            return response()->json([
                'message' => 'There are no reservations to show.'
            ]);
        }

        return response()->json($reservations);
    }

    public function getBookingTypes()
    {
        $booktype = BookingType::select('id as value', 'bookingtype as text')->get();
        return response()->json($booktype);
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
            'numberofpax' => 'required | numeric',
            'guest_id' => 'required',
            'roomid' => 'required',
            'bookingtype_id' => 'required',
            'bookingcharge' => 'numeric',
            'billing.downpayment' => 'numeric'
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
        $booking->booked_by = Auth::id();
        $booking->bookingtype_id = $request->bookingtypeid;
        $booking->bookingcharge = $request->bookingcharge;
        $booking->bookingstatus = 1; //0 - reserved, 1 - booked, 2 - checked out, 3 - paid

        $booking->save();

        $billing = new Billing();
        $billing->booking_id = $booking->id;
        $billing->downpayment = $request['billing']['downpayment'];
        $billing->totalcharges = $request->bookingcharge;

        $billing->save();

        return response()->json([
            'message' => 'Booking added successfully.'
        ]);
    }

    public function reserve(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'guest_id' => 'required',
            'checkindate' => 'required',
            'checkintime' => 'required',
            'checkoutdate' => 'required',
            'checkouttime' => 'required',
            'room_id' => 'required',
            'bookingtype_id' => 'required',
            'numberofpax' => 'required | numeric',
            'bookingcharge' => 'numeric',
            'billing.downpayment' => 'numeric'
        ],
        [
            'guest_id.required' => 'The guest name field is required.',
            'room_id.required' => 'The room information field is required.',
            'bookingtype_id.required' => 'The booking type field is required.'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $reservation = new Booking();

        $reservation->checkin = $request->checkindate . ' ' . $request->checkintime;
        $reservation->checkout = $request->checkoutdate . ' ' . $request->checkouttime;
        $reservation->numberofpax = $request->numberofpax;
        $reservation->remarks = $request->remarks;
        $reservation->reservationstatus = 0; //0 - for approval, 1 - approved, 2 - disapproved
        $reservation->reservationdate = Carbon::now();
        $reservation->guest_id = $request->guest_id;
        $reservation->room_id = $request->room_id;
        $reservation->booked_by = Auth::id();
        $reservation->bookingtype_id = $request->bookingtype_id;
        $reservation->bookingcharge = $request->bookingcharge;
        $reservation->bookingstatus = 0; //0 - reserved, 1 - booked, 2 - checked out, 3 - paid

        $reservation->save();

        $billing = new Billing();
        $billing->booking_id = $reservation->id;
        $billing->downpayment = $request['billing']['downpayment'];
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
    public function updateReservation(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'guest_id' => 'required',
            'checkindate' => 'required',
            'checkintime' => 'required',
            'checkoutdate' => 'required',
            'checkouttime' => 'required',
            'room_id' => 'required',
            'bookingtype_id' => 'required',
            'numberofpax' => 'required | numeric',
            'bookingcharge' => 'numeric',
            'billing.downpayment' => 'numeric'
        ],
        [
            'guest_id.required' => 'The guest name field is required.',
            'room_id.required' => 'The room information field is required.',
            'bookingtype_id.required' => 'The booking type field is required.'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $reservation = Booking::find($id);

        $reservation->checkin = $request->checkindate . ' ' . $request->checkintime;
        $reservation->checkout = $request->checkoutdate . ' ' . $request->checkouttime;
        $reservation->numberofpax = $request->numberofpax;
        $reservation->remarks = $request->remarks;
        $reservation->guest_id = $request->guest_id;
        $reservation->room_id = $request->room_id;
        $reservation->booked_by = Auth::id();
        $reservation->bookingtype_id = $request->bookingtype_id;
        $reservation->bookingcharge = $request->bookingcharge;

        $reservation->save();

        $billing = new Billing();
        $billing->booking_id = $reservation->id;
        $billing->downpayment = $request['billing']['downpayment'];
        $billing->totalcharges = $request->bookingcharge;

        $billing->save();

        return response()->json([
            'message' => 'Reservation detail updated successfully.'
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
        $booking = Booking::find($id);

        if(!$booking) {
            return response()->json([
                'message' => 'Booking is not found.'
            ]);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking successfully removed.'
        ]);
    }
}
