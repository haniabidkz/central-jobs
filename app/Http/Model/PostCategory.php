<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_category';

    // protected $fillable = ['title', 'country_id', 'state_id', 'city', 'position_for', 'employment_type', 
    //                     'language', 'skill', 'description', 'start_date', 'end_date', 'applyed_by', 
    //                     'website_link', 'status','user_id','post_type'];

}
