<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'statustype', 'abbreviation',
    ];

    /**
    * Define relationship to StatusHistory
    **/
    public function StatusHistory()
    {
        return $this->hasMany('App\StatusHistory');
    }
}
