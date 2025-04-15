<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentCms extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_cms';

    protected $fillable = ['name', 'value', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
}
