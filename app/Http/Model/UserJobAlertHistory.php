<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserJobAlertHistory extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_job_alert_history';

    protected $fillable = ['user_id', 'job_id', 'type', 'keyword', 'country_id', 'state_id', 'city', 'status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the phone record associated with the user.
     */
    public function country()
    {
        return $this->hasOne('App\Http\Model\Country','id','country_id');
    }    
     /**
     * Get the phone record associated with the user.
     */
    public function state()
    {
        return $this->hasOne('App\Http\Model\State','id','state_id');
    }  
}
