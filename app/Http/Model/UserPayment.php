<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_payment';

    protected $fillable = ['user_id', 'payment_id','status'];

}
