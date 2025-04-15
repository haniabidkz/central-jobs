<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
   // use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_us';

    protected $fillable = ['ip_address','created_at'];

}
