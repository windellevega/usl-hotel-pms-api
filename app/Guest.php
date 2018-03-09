<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guesttype_id', 'company_id',
        'firstname', 'lastname', 'contactno'
    ];
    protected $appends = ['fullname'];

    /**
    * Define relationship to GuestType
    **/
    public function GuestType()
    {
        return $this->belongsTo('App\GuestType', 'guesttype_id');
    }

    /**
    * Define relationship to Company
    **/
    public function Company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
    * Define relationship to Booking
    **/
    public function Booking()
    {
        return $this->hasMany('App\Booking');
    }

    /**
     * Define accessor to fullname
     */
    public function getFullnameAttribute()
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }
}
