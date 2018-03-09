<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_name', 'room_description', 'capacity',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'statusdate'];

    /**
    * Define relationship to Booking
    **/
    public function Booking()
    {
        return $this->hasMany('App\Booking');
    }

    /**
    * Define relationship to RoomRate
    **/
    public function RoomRate()
    {
        return $this->hasMany('App\RoomRate');
    }

    /**
    * Define relationship to StatusHistory
    **/
    public function StatusHistory()
    {
        return $this->hasMany('App\StatusHistory')
        ->orderBy('statusdate', 'DESC');
    }

    public function LatestStatus()
    {
        return $this->StatusHistory()->take(1);
    }
}
