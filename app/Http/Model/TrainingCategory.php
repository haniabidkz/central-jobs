<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class TrainingCategory extends Model
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
    protected $table = 'training_category';

    protected $fillable = ['name', 'description', 'course_url', 'status', 'created_at', 'updated_at', 'deleted_at', 'user_id'];

}
