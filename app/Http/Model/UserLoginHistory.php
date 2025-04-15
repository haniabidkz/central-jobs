<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_login_logout_history';

    protected $fillable = ['user_id', 'ip_address','login_time','logout_time','created_at','updated_at','deleted_at'];

}
