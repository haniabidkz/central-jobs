<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CandidateJobApplyInfo extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'candidate_job_apply_info';

     protected $fillable = ['job_applied_id', 'user_id', 'job_id', 'cover_letter','user_phone', 'user_city', 'user_state', 'user_country', 'created_at', 'updated_at', 'deleted_at'];

     /**
     * Get the phone record associated with the user.
     */
    public function country()
    {
        return $this->hasOne('App\Http\Model\Country','id','user_country');
    }    
     /**
     * Get the phone record associated with the user.
     */
    public function state()
    {
        return $this->hasOne('App\Http\Model\State','id','user_state');
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function city()
    {
        return $this->hasOne('App\Http\Model\City','id','user_city');
    }  
    
}
