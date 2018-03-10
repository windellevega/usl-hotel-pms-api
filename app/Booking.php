<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Booking extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'checkin', 'checkout'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guest_id', 'room_id', 'booked_by', 'bookingtype_id', 
        'numberofpax', 'remarks', 'reservationstatus', 'reservationdate',
         'bookingcharge', 'bookingstatus'
    ];

    protected $appends = ['checkindate', 'checkintime', 'checkoutdate', 'checkouttime', 'stayduration_days', 'stayduration_hrs'];

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
        if($value != null) {
            return date('M d, Y, h:ia', strtotime($value));
        }
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
        if($this->attributes['checkout'] != null) {
            return date('Y-m-d', strtotime($this->attributes['checkout']));
        }
        else {
            return null;
        }
        
    }

    /**
     * Define accessor to checkintime
     */
    public function getCheckouttimeAttribute()
    {
        if($this->attributes['checkout'] != null) {
            return date('H:i', strtotime($this->attributes['checkout']));
        }
        else {
            return null;
        }
    }

    /**
     * Define accessor to stayduration
     */
    public function getStaydurationDaysAttribute()
    {
        $start = Carbon::parse($this->attributes['checkin']);
        $end = Carbon::parse($this->attributes['checkout']);
        if($this->attributes['checkout'] != null) {
            $duration = $end->diffInHours($start);
            if($duration % 24 == 0 && $duration >= 24){
                return $duration / 24 . (($duration / 24 > 1) ? ' Days' : ' Day');
            }
            else if($duration < 24) {
                return $duration . ' Hrs';
            }
            else {
                $dayduration = round($duration / 24, 0, PHP_ROUND_HALF_DOWN);
                $days = $dayduration . (($dayduration > 1) ? ' Days' : ' Day');
                $hrs = $duration % 24 . (($duration % 24 > 1) ? ' Hrs' : ' Hr');
                return $days . ' ' . $hrs;
            }
            
        }
        else {
            return null;
        }
    }

    /**
     * Define accessor to stayduration
     */
    public function getStaydurationHrsAttribute()
    {
        $start = Carbon::parse($this->attributes['checkin']);
        $end = Carbon::parse($this->attributes['checkout']);
        if($this->attributes['checkout'] != null) {
            return $end->diffInHours($start);
        }
        else {
            return null;
        }
    }
}
