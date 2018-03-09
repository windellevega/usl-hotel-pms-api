<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestType extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guesttype',
    ];

    /**
    * Define relationship to Guest
    **/
    public function Guest()
    {
        return $this->hasMany('App\Guest');
    }
}
