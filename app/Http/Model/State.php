<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';

    protected $fillable = ['name', 'country_id'];
    /**
     * Get the phone record associated with the user.
     */
    public function city()
    {
        return $this->hasMany('App\Http\Model\City','state_id');
    }
}
