<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id', 'rate_id', 
        'active',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
    * Define relationship to Rate
    **/
    public function Rate()
    {
        return $this->belongsTo('App\Rate');
    }

    /**
    * Define relationship to Room
    **/
    public function Room()
    {
        return $this->belongsTo('App\Room');
    }
}
