<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserProfessionalInfo extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'user_professional_info';

     protected $fillable = ['user_id', 'title', 'type_of_employment', 'company_name', 'currently_working_here', 'start_date', 'end_date', 'status', 'created_at', 'updated_at', 'deleted_at'];
     
     public function user()
     {
         return $this->hasOne('App\Http\Model\User','id','user_id')->with('bannerImage','profileImage','profile','currentCompany','followers');
     }
}
