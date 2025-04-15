<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';

    protected $fillable = ['name', 'state_id'];
    /**
     * Get the phone record associated with the user.
     */
    
}
