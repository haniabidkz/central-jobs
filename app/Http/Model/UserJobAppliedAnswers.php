<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserJobAppliedAnswers extends Model
{   
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_job_applied_answers';

    protected $fillable = ['job_applied_id', 'job_post_specific_questions_id', 'answer','type', 'created_at', 'updated_at', 'deleted_at'];

    
    public function specificQuestion()
    {
        return $this->hasOne('App\Http\Model\JobPostSpecificQuestions','id','job_post_specific_questions_id');
    }
    
    public function upload()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id','id')->where('type','user_interview_video');
    }
   
}
