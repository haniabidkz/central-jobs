<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    protected $fillable = ['school_name', 'degree', 'user_id', 'profile_headline', 'subject', 
                            'start_year', 'end_year', 'business_name', 'employment_type', 'start_date', 
                            'end_date', 'language', 'proficiency', 'hobby', 'cv_summary', 'highlight_sentence',
                            'user_cv_upload_id', 'created_at', 'updated_at', 'approve_status', 'reason'];

     /**
     * Get the phone record associated with the user.
     */
    public function uploadCv()
    {
        return $this->belongsTo('App\Http\Model\Upload','user_cv_upload_id');
    } 
    public function uploadVideo()
    {
        return $this->belongsTo('App\Http\Model\Upload','user_video_intro_upload_id');
    }   

}   
