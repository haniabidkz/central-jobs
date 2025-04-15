<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CronJobMaster extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'cron_job_master';

     protected $fillable = ['to_user_id', 'from_user_id', 'type_id', 'type', 'job_count', 'created_at', 'updated_at', 'deleted_at'];
    
     /**
     * Get the phone record associated with the user.
     */
    public function toUser()
    {
        return $this->hasOne('App\\Http\Model\User','id','to_user_id')->where('status','=',1)->with('profileImage','profile','currentCompany','followers');
    }  

    public function fromUser()
    {
        return $this->hasOne('App\\Http\Model\User','id','from_user_id')->where('status','=',1)->with('profileImage','profile','followers');
    }  

    public function appliedUserInfo()
    {
        return $this->hasOne('App\Http\Model\CandidateJobApplyInfo','job_applied_id','type_id')->with('country','state');
    }

    public function jobPost()
    {
        return $this->hasOne('App\Http\Model\JobPost','id','job_id')->with('country','state','company');
    }

    public function jobPostDetails()
    {
        return $this->hasOne('App\Http\Model\JobPost','id','type_id')->with('country','state','company');
    }
}
