<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div style="height:580px;margin:0;padding:0;">
        <?php //dd($booking->Guest->GuestType->guesttype) ?>
        <div id="heading" style="text-align:center;">
            <strong>TJOLLE INTERNATIONAL HOTEL - LECAROS EXTENSION</strong><br>
            <span>BOOKING INVOICE</span>
        </div>
        <div>
            <table style="width:715px;padding-top:15px;">
                <tr>
                    <td><strong>Guest Name:</strong> {{ $booking->Guest->firstname }} {{ $booking->Guest->lastname }}</td>
                    <td><strong>Guest Type:</strong> {{ $booking->Guest->GuestType->guesttype }}</td>
                </tr>
                <tr>
                    <td><strong>Company:</strong> {{ $booking->Guest->Company->companyname }}, {{ $booking->Guest->Company->companyaddress }}</td>
                    <td><strong>Booking Type:</strong> {{ $booking->BookingType->bookingtype }}</td>
                </tr>
                <tr>
                    <td><strong>Room:</strong> {{ $booking->Room->room_name }}</td>
                    <td><strong>No. of Pax:</strong> {{ $booking->numberofpax }}</td>
                </tr>
                <tr>
                    <td><strong>Check-In:</strong> {{ $booking->actual_checkin }}</td>
                    <td><strong>Check-Out:</strong> {{ $booking->actual_checkout }}</td>
                </tr>
            </table>
            <table style="width:690px;margin-top:15px;border-collapse:collapse;margin-left:20px;">
                <tr style="text-align:center;">
                    <th colspan="4" style="border:0.25px solid #000;">SUMMARY OF CHARGES</th>
                </tr>
                <tr style="text-align:center;">
                    <th style="border:0.25px solid #000;width:40%;">Name</th>
                    <th style="border:0.25px solid #000;width:25%;">Cost per Qty</th>
                    <th style="border:0.25px solid #000;width:10%;">Quantity</th>
                    <th style="border:0.25px solid #000;width:25%;">Total Cost</th>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left:10px;"><strong>Booking Charge</strong></td>
                    <td style="text-align:right;padding-right:10px;"> {{ $booking->bookingcharge }}</td>
                </tr>
                @foreach ($booking->Billing->OtherCharge as $othercharge)
                <tr>
                    <td style="padding-left:10px;">{{ $othercharge->othercharge_info }}</td>
                    <td style="text-align:center;">{{ $othercharge->cost }}</td>
                    <td style="text-align:center;">{{ $othercharge->quantity }}</td>
                    <td style="text-align:right;padding-right:10px;">{{ $othercharge->cost * $othercharge->quantity }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="border-bottom:2px solid #000;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total Charges:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->totalcharges }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Downpayment:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->downpayment }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right;">-------------------------------------------------------------</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Amount Due:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->totalcharges - $booking->Billing->downpayment }}</td>
                </tr>
            </table>
            <span style="margin-left:40px;position:fixed;top:500px;"><strong>Served By:</strong> {{ $booking->User->firstname }} {{ $booking->User->lastname }}</span>
        </div>
    </div>
    <div style="height:515px;padding-top:40px;">
    <div id="heading" style="text-align:center;">
            <strong>TJOLLE INTERNATIONAL HOTEL - LECAROS EXTENSION</strong><br>
            <span>BOOKING INVOICE</span>
        </div>
        <div>
            <table style="width:715px;padding-top:15px;">
                <tr>
                    <td><strong>Guest Name:</strong> {{ $booking->Guest->firstname }} {{ $booking->Guest->lastname }}</td>
                    <td><strong>Guest Type:</strong> {{ $booking->Guest->GuestType->guesttype }}</td>
                </tr>
                <tr>
                    <td><strong>Company:</strong> {{ $booking->Guest->Company->companyname }}, {{ $booking->Guest->Company->companyaddress }}</td>
                    <td><strong>Booking Type:</strong> {{ $booking->BookingType->bookingtype }}</td>
                </tr>
                <tr>
                    <td><strong>Room:</strong> {{ $booking->Room->room_name }}</td>
                    <td><strong>No. of Pax:</strong> {{ $booking->numberofpax }}</td>
                </tr>
                <tr>
                    <td><strong>Check-In:</strong> {{ $booking->actual_checkin }}</td>
                    <td><strong>Check-Out:</strong> {{ $booking->actual_checkout }}</td>
                </tr>
            </table>
            <table style="width:690px;margin-top:15px;border-collapse:collapse;margin-left:20px;">
                <tr style="text-align:center;">
                    <th colspan="4" style="border:0.25px solid #000;">SUMMARY OF CHARGES</th>
                </tr>
                <tr style="text-align:center;">
                    <th style="border:0.25px solid #000;width:40%;">Name</th>
                    <th style="border:0.25px solid #000;width:25%;">Cost per Qty</th>
                    <th style="border:0.25px solid #000;width:10%;">Quantity</th>
                    <th style="border:0.25px solid #000;width:25%;">Total Cost</th>
                </tr>
                <tr>
                    <td colspan="3" style="padding-left:10px;"><strong>Booking Charge</strong></td>
                    <td style="text-align:right;padding-right:10px;"> {{ $booking->bookingcharge }}</td>
                </tr>
                @foreach ($booking->Billing->OtherCharge as $othercharge)
                <tr>
                    <td style="padding-left:10px;">{{ $othercharge->othercharge_info }}</td>
                    <td style="text-align:center;">{{ $othercharge->cost }}</td>
                    <td style="text-align:center;">{{ $othercharge->quantity }}</td>
                    <td style="text-align:right;padding-right:10px;">{{ $othercharge->cost * $othercharge->quantity }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="border-bottom:2px solid #000;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total Charges:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->totalcharges }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Downpayment:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->downpayment }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right;">-------------------------------------------------------------</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Amount Due:</strong></td>
                    <td style="text-align:right;padding-right:10px;">P{{ $booking->Billing->totalcharges - $booking->Billing->downpayment }}</td>
                </tr>
            </table>
            <span style="margin-left:40px;position:fixed;top:1115px;"><strong>Served By:</strong> {{ $booking->User->firstname }} {{ $booking->User->lastname }}</span>
        </div>
    </div>
</body>
</html>