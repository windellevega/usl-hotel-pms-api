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
        'billing_id', 'quantity',
        'othercharge_info', 'cost',
    ];
    protected $appends = ['totalcost'];

    /**
    * Define relationship to Billing
    **/
    public function Billing()
    {
        return $this->belongsTo('App\Billing');
    }

    /**
     * Define accessor to totalcost
     */
    public function getTotalcostAttribute()
    {
        return number_format($this->attributes['cost'] * $this->attributes['quantity'], 2);
    }
}
