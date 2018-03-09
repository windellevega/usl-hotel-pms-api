<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_id', 'room_id',
        'statusdate', 'remarks',
    ];

    /**
    * Define relationship to Status
    **/
    public function Status()
    {
        return $this->belongsTo('App\Status');
    }

    /**
    * Define relationship to Room
    **/
    public function Room()
    {
        return $this->belongsTo('App\Room');
    }
}
