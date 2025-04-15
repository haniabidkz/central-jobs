<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscription_history';

    protected $fillable = ['service_id','title', 'description', 'instruction','price', 'payment_url', 'status', 'created_at', 'updated_at', 'deleted_at'];

}
