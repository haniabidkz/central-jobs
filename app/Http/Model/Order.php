<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
    protected $table = 'orders';

    protected $fillable = ['candidate_name','candidate_email','amount','subscription_code','service_start_from', 'propose_date_2', 'propose_date_3', 'payment_url','additional_info','subscription_id','subs_history_id', 'user_id', 'status', 'created_at', 'updated_at', 'deleted_at'];

     /**
     * Get the order record associated with the subscription.
     */
    public function subscription()
    {
        return $this->hasOne('App\Http\Model\Subscription','id','subscription_id');
    } 
     /**
     * Get the order record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id');
    } 
     /**
     * Get the order record associated with the subscription.
     */
    public function subscription_history()
    {
        return $this->hasOne('App\Http\Model\SubscriptionHistory','id','subs_history_id');
    } 
    
}
