<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ReportedPost extends Model
{   
    
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
    protected $table = 'reports';

    protected $fillable = [ 'type', 'type_id', 'comment', 'status', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

      
     /**
     * Get the phone record associated with the user.
     */
    public function reporterUser()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id')->with('profile','profileImage');
    }  
   
     /**
     * Get the phone record associated with the user.
     */
    public function post()
    {
        return $this->hasOne('App\Http\Model\JobPost','id','type_id')->with('user','upload');
    }

     /**
     * Get the phone record associated with the user.
     */
    public function comment()
    {
        return $this->hasOne('App\Http\Model\CommonComment','id','type_id')->with('user','post');
    }

     /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','type_id')->with('profile','profileImage');
    } 
}
