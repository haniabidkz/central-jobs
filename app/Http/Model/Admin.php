<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id', 'default_invitation_subject', 'default_invitation_message'];

    /**
     * Association with user.
     *
    */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();;
    }

    /**
     * Referrer Association
     *
    */
    public function sentInvitations()
    {
        return $this->morphMany(Invitation::class, 'referrer');
    }
    
    /**
     * Function to Get Admin Email
     *
    */
    public static function adminEmail()
    {
    	$admin = User::select('id','email')->where('type','admin')->where('is_active',1)->first();
        return $admin->email;
    }

}
