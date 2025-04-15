<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplied extends Model
{   
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_applied';

    protected $fillable = ['job_id', 'user_id','status', 'applied_status', 'apply_date'];

    
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id')->with('profileImage','profile','currentCompany','uploadedCV','state','country','city','userLanguageFluency');
    }
    
    public function jobPost()
    {
        return $this->belongsTo('App\Http\Model\JobPost','job_id','id')->with('country','state','company');
    }

    public function uploaded_cv()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id','user_id');
    }

    public function uploaded_other_doc()
    {
        return $this->hasMany('App\Http\Model\Upload','type_id','user_id');
    }

    public function appliedAnswer()
    {
        return $this->hasMany('App\Http\Model\UserJobAppliedAnswers','job_applied_id','id')->with('specificQuestion','upload');
    }

    public function appliedUserInfo()
    {
        return $this->hasOne('App\Http\Model\CandidateJobApplyInfo','job_applied_id','id')->with('country','state','city');
    }
    
}
