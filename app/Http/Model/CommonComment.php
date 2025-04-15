<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonComment extends Model
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
    protected $table = 'common_comments';

    protected $fillable = ['type', 'comment', 'user_id', 'created_at', 'updated_at', 'deleted_at', 'status', 'type_id'];

     /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id')->with('profileImage');
    }  
     /**
     * Get the phone record associated with the user.
     */
    public function activeUser()
    {
        return $this->hasOne('App\\Http\Model\User','id','user_id')->where('status','=',1)->with('profileImage','profile','currentCompany');
    } 
     /**
     * Get the phone record associated with the user.
     */
    public function commentPost()
    {
        return $this->hasOne('App\Http\Model\JobPost','id','type_id')->with('user');
    }  
   
    public function report()
    {
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->with('reporterUser')->orderBy('status', 'ASC');
    } 

     /**
     * Get the phone record associated with the user.
     */
    public function post()
    {
        return $this->hasOne('App\Http\Model\JobPost','id','type_id')->with('user','upload');
    }
    public function reported()
    {
        return $this->hasMany('App\Http\Model\ReportedPost','type_id','id')->whereIn('status', array(0,1))->where('type','=','post_comment');
    } 
    
   
}
