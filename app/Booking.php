<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guest_id', 'room_id', 'booked_by', 'bookingtype_id', 
        'checkin', 'checkout', 'numberofpax',
         'remarks', 'reservationstatus', 'reservationdate',
         'bookingcharge',
    ];

    /**
    * Define relationship to Billing
    **/
    public function Billing()
    {
        return $this->hasOne('App\Billing');
    }

    /**
    * Define relationship to BookingType
    **/
    public function BookingType()
    {
        return $this->belongsTo('App\BookingType');
    }

    /**
    * Define relationship to Room
    **/
    public function Room()
    {
        return $this->belongsTo('App\Room');
    }

    /**
    * Define relationship to User
    **/
    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
