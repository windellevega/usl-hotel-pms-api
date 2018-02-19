<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherCharge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'billing_id',
        'othercharge_info', 'cost',
    ];

    /**
    * Define relationship to Billing
    **/
    public function Billing()
    {
        return $this->belongsTo('App\Billing');
    }
}
