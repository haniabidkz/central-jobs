<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['last_name','first_name', 'role', 'email', 'password', 'remember_token', 'created_at', 'updated_at', 
    //                         'deleted_at', 'address1','address2', 'state_id', 'country_id', 'postal', 
    //                         'telephone', 'status', 'approve_status'];

   
    protected $fillable = ['first_name','company_name','telephone','slug','address1','country_id','state_id','address2','postal','is_mcq_complete','is_notification_on','email', 'is_newsletter_subscribed','cnpj','password','user_type','terms_conditions_status','privacy_policy_status','cookies_policy_status' ,'status','created_at', 'updated_at', 'deleted_at'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getEmailAttribute($value) {
        return base64_decode($value);
    }

    public function setEmailAttribute($value) {
        $this->attributes['email'] = base64_encode($value);
    }

    public function getFirstNameAttribute($value) {
        return base64_decode($value);
    }

    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = base64_encode($value);
    }

    public function getTelephoneAttribute($value) {
        return base64_decode($value);
    }

    public function setTelephoneAttribute($value) {
        $this->attributes['telephone'] = base64_encode($value);
    }

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
    /* Get the phone record associated with the profile.
    */
    public function profile()
    {
        return $this->belongsTo('App\Http\Model\Profile','id','user_id');
    }  
    /* Get the phone record associated with the profile.
    */
    public function report()
    {
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->with('reporterUser');
    }  
    public function profileImage()
    {
        return $this->hasOne('App\Http\Model\Upload','id','user_id');
    } 
    public function job()
    {
        return $this->hasMany('App\Http\Model\JobPost','user_id','id');
    } 
    public function appliedJob()
    {
        return $this->hasMany('App\Http\Model\JobApplied','user_id','id');
    } 
    public function post()
    {
        return $this->hasMany('App\Http\Model\JobPost','user_id','id');
    } 
    public function currentCompany()
    {
        return $this->hasOne('App\Http\Model\UserProfessionalInfo','user_id','id')->where('currently_working_here',1);
    } 
    
}
