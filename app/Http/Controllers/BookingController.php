<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use PDF;

use App\Booking;
use App\BookingType;
use App\Billing;
use App\Room;
use App\StatusHistory;
use App\User;

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
        $bookings->load('Guest.GuestType', 'Guest.Company');
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

    public function getTransactions()
    {
        $transactions = Booking::where('bookingstatus', 3)
                            ->orderBy('room_id')
                            ->orderBy('checkin')
                            ->get();
        $transactions->load('Room');
        $transactions->load('Guest.GuestType', 'Guest.Company');
        $transactions->load('BookingType');
        $transactions->load('User');
        $transactions->load('Billing');

        if($transactions->count() <= 0) {
            return response()->json([
                'message' => 'There are no transactions to show.'
            ]);
        }
        return response()->json($transactions);
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
            'numberofpax' => 'required | numeric',
            'checkoutdate' => 'required',
            'checkouttime' => 'required',
            'guest_id' => 'required',
            'room_id' => 'required',
            'bookingtype_id' => 'required',
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

        $booking = new Booking();

        $booking->checkin = Carbon::now();
        $booking->checkout = $request->checkoutdate . ' ' . $request->checkouttime;
        $booking->numberofpax = $request->numberofpax;
        $booking->remarks = $request->remarks;
        $booking->guest_id = $request->guest_id;
        $booking->room_id = $request->room_id;
        $booking->booked_by = Auth::id();
        $booking->bookingtype_id = $request->bookingtype_id;
        $booking->bookingcharge = $request->bookingcharge;
        $booking->bookingstatus = 1; //0 - reserved, 1 - booked, 2 - checked out, 3 - paid
        $booking->actual_checkin = Carbon::now();

        $booking->save();

        $billing = new Billing();
        $billing->booking_id = $booking->id;
        $billing->downpayment = $request['billing']['downpayment'];
        $billing->totalcharges = $request->bookingcharge;

        $billing->save();

        $roomhistory = new StatusHistory();
        $roomhistory->status_id = 4;
        $roomhistory->room_id = $request->room_id;
        $roomhistory->statusdate = Carbon::now();
        $roomhistory->remarks = 'Walk-in booking';

        $roomhistory->save();

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
        $reservation->bookingstatus = 0; //0 - reserved, 1 - booked, 2 - checked out

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

    public function recordTransaction(Request $request)
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

        //return response()->json($request);
        $transaction = new Booking();

        $transaction->checkin = $request->checkindate . ' ' . $request->checkintime;
        $transaction->actual_checkin = $request->checkindate . ' ' . $request->checkintime;
        $transaction->checkout = $request->checkoutdate . ' ' . $request->checkouttime;
        $transaction->actual_checkout = $request->checkoutdate . ' ' . $request->checkouttime;
        $transaction->numberofpax = $request->numberofpax;
        $transaction->remarks = $request->remarks;
        $transaction->reservationstatus = 1; //0 - for approval, 1 - approved, 2 - disapproved
        $transaction->reservationdate = $request->reservationdate;
        $transaction->guest_id = $request->guest_id;
        $transaction->room_id = $request->room_id;
        $transaction->booked_by = 1;
        $transaction->bookingtype_id = $request->bookingtype_id;
        $transaction->bookingcharge = $request->bookingcharge;
        $transaction->bookingstatus = 3; //0 - reserved, 1 - booked, 2 - checked out

        $transaction->save();

        $billing = new Billing();
        $billing->booking_id = $transaction->id;
        $billing->downpayment = $request['billing']['downpayment'];
        $billing->totalcharges = $request['billing']['totalcharges'];

        $billing->save();

        return response()->json([
            'message' => 'Transaction added successfully.'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $bstatus = 'all')
    {
        $booking = Booking::where('id', $id)
                    ->get();
        
        $booking->load('BookingType');
        $booking->load('Room');
        $booking->load('Billing');
        $booking->load('Billing.OtherCharge');
        $booking->load('Guest.GuestType', 'Guest.Company');

        if($booking->count() != 0) {
            return response()->json($booking);
        }
        else {
            return response()->json([
                'message' => "This booking doesn't exist"
            ]);
        }
    }

    public function showBookingByRoom($roomid)
    {

        $booking = Booking::where('room_id', $roomid)
                    ->where('bookingstatus', 1)
                    ->first();
        
        $booking->load('BookingType');
        $booking->load('Room');
        $booking->load('Billing');
        $booking->load('Billing.OtherCharge');
        $booking->load('Guest.GuestType', 'Guest.Company');

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
        $reservation->updated_by = Auth::id();
        $reservation->bookingtype_id = $request->bookingtype_id;
        $reservation->bookingcharge = $request->bookingcharge;

        $reservation->save();

        $billing = Billing::where('booking_id', $reservation->id)
                    ->first();
        $billing->downpayment = $request['billing']['downpayment'];
        $billing->totalcharges = $request->bookingcharge;

        $billing->save();

        return response()->json([
            'message' => 'Reservation detail updated successfully.'
        ]);
    }

    public function modifyBookingCharge(Request $request, $id)
    {
        $booking = Booking::find($id);

        $chargeDiff = $booking->bookingcharge - $request->bookingcharge;
        $oldcharge = $booking->bookingcharge;

        $booking->bookingcharge = $request->bookingcharge;
        $booking->save();

        $billing = Billing::where('booking_id', $id)
                    ->first();
        $billing->totalcharges -= $chargeDiff;
        $billing->save();

        return response()->json([
            'message' => 'Booking charge has been changed from ₱' . $oldcharge . ' to ₱' . $request->bookingcharge . '.'
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

    /**
     * Check-out specified booking
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'room_id' => 'required',
            'roomstatus' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $booking = Booking::find($id);
        $booking->bookingstatus = 2;
        $booking->actual_checkout = Carbon::now();
        $booking->save();

        $statushistory = new StatusHistory();
        $statushistory->status_id = $request->roomstatus;
        $statushistory->room_id = $request->room_id;
        $statushistory->statusdate = Carbon::now();
        $statushistory->remarks = 'Status after room check-out';
        $statushistory->save();

        return response()->json([
            'message' => 'Room successfully checked-out'
        ]);
    }

    public function generateInvoice($roomid) {
        $booking = Booking::where('room_id', $roomid)
                    ->where('bookingstatus', 1)
                    ->first();
        
        $booking->load('BookingType');
        $booking->load('Room');
        $booking->load('Billing');
        $booking->load('Billing.OtherCharge');
        $booking->load('Guest.GuestType', 'Guest.Company');
        $booking->load('User');

        if($booking->count() == 0) {
            return response()->json([
                'message' => "This booking doesn't exist"
            ]);
        }

        $pdf = PDF::loadView('invoice', compact('booking'))
                ->setPaper(array(0,0,612,936), 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
