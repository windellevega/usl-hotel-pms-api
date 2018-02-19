<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bookingtype',
    ];

    /**
    * Define relationship to Booking
    **/
    public function Booking()
    {
        return $this->hasMany('App\Booking');
    }
}
