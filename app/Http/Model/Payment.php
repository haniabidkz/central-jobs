<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
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
    protected $table = 'payments';

    protected $fillable = ['order_id', 'subscription_id', 'user_id', 'status', 'created_at', 'updated_at', 'deleted_at'];

     /**
     * Get the order record associated with the subscription.
     */
    public function subscription()
    {
        return $this->hasOne('App\Http\Model\Subscription','id','service_id');
    } 
     /**
     * Get the order record associated with the subscription.
     */
    public function order()
    {
        return $this->hasOne('App\Http\Model\Order','id','order_id');
    }
     /**
     * Get the order record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id');
    } 
}
