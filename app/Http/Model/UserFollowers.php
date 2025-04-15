<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserFollowers extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_followers';

    protected $fillable = ['user_id', 'follower_id', 'created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','follower_id')->where('status',1)->with('profileImage','profile','isUserBlockedByLogedInUser');
    } 
    public function followingUser()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id')->with('bannerImage','profileImage','profile','currentCompany');
    }
    
    public function userToJobAlert()
    {
        return $this->hasOne('App\Http\Model\User','id','follower_id')->where([['status',1],['is_notification_on',1]])->with('profileImage','profile');
    } 
}
