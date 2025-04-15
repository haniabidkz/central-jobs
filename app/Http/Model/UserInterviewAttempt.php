<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserInterviewAttempt extends Model
{   
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_interview_attempts';

    protected $fillable = ['user_id', 'job_id', 'question_id', 'filename', 'location', 'is_selected','status', 'created_at', 'updated_at', 'deleted_at'];

    
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id')->with('profileImage','profile','currentCompany','uploadedCV','state','country','userLanguageFluency');
    }
    
    public function jobPost()
    {
        return $this->belongsTo('App\Http\Model\JobPost','job_id','id')->with('country','state','company');
    }

   
}
