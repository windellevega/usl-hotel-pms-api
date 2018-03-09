<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'companyname', 'companyaddress',
    ];

    /**
    * Define relationship to Guest
    **/
    public function Guest()
    {
        return $this->hasMany('App\Guest');
    }
}
