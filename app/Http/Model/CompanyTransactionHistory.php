<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyTransactionHistory extends Model
{
    protected $fillable = [
        'payment_id','user_id','amount','currency','payment_status', 'balance_transaction',
        'captured','paid','disputed','payment_method','receipt_url','description'
    ];

    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id');
    }   
}
