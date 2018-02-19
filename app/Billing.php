<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id', 
        'downpayment', 'totalcharges',
    ];

    /**
    * Define relationship to Booking
    **/
    public function Booking()
    {
        return $this->belongsTo('App\Booking');
    }

    /**
    * Define relationship to OtherCharge
    **/
    public function OtherCharge()
    {
        return $this->hasMany('App\OtherCharge');
    }
}
