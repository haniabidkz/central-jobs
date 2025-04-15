<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserEducatioalInfo extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'user_educatioal_info';

     protected $fillable = ['user_id', 'school_name', 'degree', 'subject', 'start_year', 'end_year', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
}
