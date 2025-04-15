<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    protected $fillable = ['sortname', 'name', 'phonecode'];
    /**
     * Get the user that owns the phone.
     */
    public function job()
    {
        return $this->belongsTo('App\Http\Model\Job');
    }
    public function states()
    {
        return $this->hasMany('App\Http\Model\State','country_id')->with('city');
    }
}
