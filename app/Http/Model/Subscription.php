<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
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
    protected $table = 'subscriptions';

    protected $fillable = ['title', 'description', 'instruction','price', 'payment_url', 'status', 'created_at', 'updated_at', 'deleted_at'];

}
