<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grouprate', 'solorate', 'ratedescription',
    ];

    /**
    * Define relationship to RoomRate
    **/
    public function RoomRate()
    {
        return $this->hasMany('App\RoomRate');
    }
}
