<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guesttype_id', 'company_id',
        'firstname', 'lastname', 'contactno',
    ];

    /**
    * Define relationship to GuestType
    **/
    public function GuestType()
    {
        return $this->belongsTo('App\GuestType');
    }

    /**
    * Define relationship to Company
    **/
    public function Company()
    {
        return $this->belongsTo('App\Company');
    }
}
