<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BlockMessage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_blocking';

    protected $fillable = ['blocked_by', 'blocked_user_id','created_at','updated_at','deleted_at'];

}
