<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{   
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    protected $fillable = ['user_id', 'job_id','title', 'slug','country_id', 'state_id', 'city','type', 'position_for', 'employment_type', 'language', 'description', 'start_date', 'end_date', 'applied_by', 'category_id', 'website_link', 'status', 'job_status','highlighted', 'created_at', 'updated_at', 'deleted_at'];

     /**
     * Get the  record associated with the country.
     */
    public function country()
    {
        return $this->hasOne('App\Http\Model\Country','id','country_id');
    }    
     /**
     * Get the  record associated with the statue.
     */
    public function state()
    {
        return $this->hasOne('App\Http\Model\State','id','state_id');
    }    
    /**
     * Get the phone record associated with the user.
     */
    public function postState()
    {
        return $this->hasMany('App\Http\Model\postState','post_id','id')->with('state');
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\\Http\Model\User','id','user_id')->where('status','=',1)->with('profileImage','profile','currentCompany','followers');
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function company()
    {
        return $this->hasOne('App\\Http\Model\User','id','user_id')->where([['user_type','=',3],['status','=',1]])->with('profileImage','profile','currentCompany','followers','followerToAlert');
    }
     /**
     * Get the phone record associated with the user.
     */
    public function upload()
    {
        return $this->hasOne('App\Http\Model\Upload','type_id','id')->where('type','post');
    }   
 
    
     /**
     * Get the phone record associated with the user.
     */
    public function postCategory()
    {
        return $this->hasOne('App\Http\Model\PostCategory','id','category_id');
    }

    /**
     * Get the phone record associated with the user.
     */
    public function selectedSkill()
    {
        return $this->hasMany('App\Http\Model\selectedSkill','type_id','id')->with('skill');
    }  
    public function report()
    {
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->with('reporterUser')->orderBy('status', 'ASC');
    } 
    public function totalAppliedJob()
    {
        return $this->hasMany('App\Http\Model\JobApplied','job_id','id')->where('applied_status',2)->with('user','appliedAnswer','appliedUserInfo');
    } 
     /**
     * Get the phone record associated with the user.
     */
    public function cmsBasicInfo()
    {
        return $this->hasMany('App\Http\Model\JobpostCmsBasicInfo','post_id','id')->with('masterInfo');
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function questions()
    {
        return $this->hasMany('App\Http\Model\JobPostSpecificQuestions','post_id','id');
    }
    public function likes()
    {
        return $this->hasMany('App\Http\Model\UserPostLike','post_id','id')->where('status',1);
    } 
    public function comments()
    {
        return $this->hasMany('App\Http\Model\CommonComment','type_id','id')->where('status',1)->with('reported');
    }
    public function reportedPost()
    {
        if(Auth::user()){
            $userId = Auth::user()->id;
        }else{
            $userId = 0;
        }
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->whereIn('status', array(0,1))->where([['type','post'],['user_id',$userId]]);
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function userIsFollowing()
    {
        return $this->hasOne('App\\Http\Model\UserFollowers','user_id','user_id');
    }
    public function isApplied()
    {
        $userId = 0;
        if(Auth::check()){
            $userId = Auth::user()->id;
        }
        return $this->hasOne('App\Http\Model\JobApplied','job_id','id')->where('user_id',$userId);
    } 

    public function sharedPost()
    {
        return $this->hasOne('App\Http\Model\UserPostShare','post_id','id')->with('post');
    }
}
