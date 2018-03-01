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

    protected $appends = ['checkindate', 'checkintime', 'checkoutdate', 'checkouttime'];

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
        return $this->belongsTo('App\BookingType', 'bookingtype_id');
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
        return $this->belongsTo('App\User', 'booked_by');
    }

    /**
     * Define relationship to guest
     */
    public function Guest()
    {
        return $this->belongsTo('App\Guest');
    }

    /**
     * Define accessor to format checkin attribute
     */
    public function getCheckinAttribute($value)
    {
        return date('M d, Y, h:ia', strtotime($value));
    }

    /**
     * Define accessor to format checkout attribute
     */
    public function getCheckoutAttribute($value)
    {
        return date('M d, Y, h:ia', strtotime($value));
    }

    /**
     * Define accessor to checkindate
     */
    public function getCheckindateAttribute()
    {
        return date('Y-m-d', strtotime($this->attributes['checkin']));
    }

    /**
     * Define accessor to checkintime
     */
    public function getCheckintimeAttribute()
    {
        return date('H:i', strtotime($this->attributes['checkin']));
    }
    
    /**
     * Define accessor to checkindate
     */
    public function getCheckoutdateAttribute()
    {
        return date('Y-m-d', strtotime($this->attributes['checkout']));
    }

    /**
     * Define accessor to checkintime
     */
    public function getCheckouttimeAttribute()
    {
        return date('H:i', strtotime($this->attributes['checkout']));
    }
}
