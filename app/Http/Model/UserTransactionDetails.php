<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserTransactionDetails extends Model
{
    protected $fillable = [
        'user_id','subscription_plan_id','card_id','currency', 'amount','customer_id','subscription_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id');
    }   
}
