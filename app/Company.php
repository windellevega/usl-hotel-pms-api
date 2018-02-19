<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'companyname',
    ];

    /**
    * Define relationship to Guest
    **/
    public function Guest()
    {
        return $this->hasMany('App\Guest');
    }
}
