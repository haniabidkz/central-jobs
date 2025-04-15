<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_connections';

    protected $fillable = ['request_sent_by', 'request_accepted_by', 'personal_note', 'status', 'created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','request_sent_by')->with('bannerImage','profileImage','profile','currentCompany','followers');
    }
    public function user1()
    {
        return $this->hasOne('App\Http\Model\User','id','request_accepted_by')->with('bannerImage','profileImage','profile','currentCompany','followers');
    }
    public function userConnectedWithCompany()
    {
        return $this->hasOne('App\Http\Model\User','id','request_accepted_by')->with('bannerImage','profileImage','profile','currentCompany','followers');
    }

}
