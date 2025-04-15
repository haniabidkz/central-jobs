<?php

namespace App\Http\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class User extends Authenticatable
{
    
    use Notifiable;
    use SoftDeletes;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['first_name', 'last_name', 'company_name', 'user_type', 'email', 'password', 'remember_token', 'country_id', 'state_id', 'postal', 'address1', 'address2', 'telephone', 'profile_img_upload_id','profile_bg_img_upload_id', 'block_reason', 'status', 'created_at', 'updated_at', 'deleted_at'];
     protected $fillable = ['id','first_name','company_name','telephone','address1','country_id','state_id','city_id','address2','postal','slug','is_mcq_complete','is_notification_on','email', 'is_newsletter_subscribed' ,'cnpj', 'password','user_type','terms_conditions_status', 'privacy_policy_status','cookies_policy_status', 'status',
     'subscription_plan_id','card_id','customer_id','subscription_id','highlight_cv',
     'created_at', 'updated_at', 'deleted_at'];
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
     /**
     * Get the phone record associated with the user.
     */
    public function city()
    {
        return $this->hasOne('App\Http\Model\City','id','city_id');
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
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->where([['status','=',0],['type','=','company']])->with('reporterUser');
    }  
    public function profileImage()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id')->where('type','=', 'profile_img');
    }
    public function introVideo()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id')->where('type','=', 'user_video_intro');
    } 
    public function bannerImage()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id')->where('type','=', 'banner_img');
    } 
    public function uploadedCV()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id')->where('type','=', 'user_cv')->whereNull('job_id');
    } 
    public function job()
    {
        return $this->hasMany('App\Http\Model\JobPost','user_id','id');
    } 
    public function appliedJob()
    {
        return $this->hasMany('App\Http\Model\JobApplied','user_id','id');
    } 
    public function upload()
    {
        return $this->belongsTo('App\Http\Model\Upload','profile_img_upload_id');
    } 

    public function uploadOtherDoc($job_id)
    {
        return $this->hasMany('App\Http\Model\Upload','type_id')->where('type','=', 'user_other_doc')->where('job_id', $job_id)->get();
    } 
    public function uploadJobCV($job_id)
    {
        return $this->hasMany('App\Http\Model\Upload','type_id')->where('type','=', 'user_cv')->where('job_id', $job_id)->first();
    } 
    public function uploadBg()
    {
        return $this->belongsTo('App\Http\Model\Upload','type_id');
    } 
    public function selectedSkill()
    {
        return $this->hasMany('App\Http\Model\selectedSkill','type_id','id')->with('skill');
    }
    public function post()
    {
        return $this->hasMany('App\Http\Model\JobPost','user_id','id')->with('upload');
    } 
    public function activePost()
    {
        return $this->hasMany('App\Http\Model\JobPost','user_id','id')->where('status','=',1)->with('upload');
    } 
    public function cmsBasicInfo()
    {
        return $this->hasMany('App\Http\Model\CmsBasicInfo','user_id','id')->where('fluency_lang_id','=', null)->with(['hobby','language']);
    } 
    public function userSkill()
    {
        return $this->hasMany('App\Http\Model\selectedSkill','type_id','id')->where('type','=','candidate')->with('skill');
    }
    public function professionalInfo()
    {
        return $this->hasMany('App\Http\Model\UserProfessionalInfo','user_id','id')->orderBy('id',"desc");
    } 
    public function educationalInfo()
    {
        return $this->hasMany('App\Http\Model\UserEducatioalInfo','user_id','id')->orderBy('id',"desc");
    } 
    public function currentCompany()
    {
        return $this->hasOne('App\Http\Model\UserProfessionalInfo','user_id','id')->where('currently_working_here',1);
    }
    public function userLanguageFluency()
    {
        return $this->hasMany('App\Http\Model\CmsBasicInfo','user_id','id');
    } 
    public function followers()
    {
        return $this->hasMany('App\Http\Model\UserFollowers','user_id','id')->orderBy('id',"desc");
    } 
    public function connection()
    {
        return $this->hasMany('App\Http\Model\UserConnection','request_accepted_by','id');
    } 
    public function connectionAcceptBy()
    {
        return $this->hasMany('App\Http\Model\UserConnection','request_sent_by','id');
    } 
    
    public function followerToAlert()
    {
        return $this->hasMany('App\Http\Model\UserFollowers','user_id','id')->with('userToJobAlert')->orderBy('id',"desc");
    }

    public function isBlocked()
    {
        return $this->belongsTo('App\Http\Model\BlockMessage','id','blocked_user_id')->where('blocked_by',Auth::user()->id);
    }
    
    public function payment()
    {
        return $this->belongsTo('App\Http\Model\UserPayment','id','user_id');
    }
    
    public function isUserBlockedByLogedInUser(){
        if(Auth::user()){
            $userId = Auth::user()->id;
        }else{
            $userId = 0;
        }
        return $this->belongsTo('App\Http\Model\UserBlock','id','blocked_user_id')->where('blocked_by',$userId);
    }
    public function isLogedInUserBlock(){
        return $this->belongsTo('App\Http\Model\UserBlock','id','blocked_by')->where('blocked_user_id',Auth::user()->id);
    }
}
