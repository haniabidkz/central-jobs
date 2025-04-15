<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class TrainingVideo extends Model
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
    protected $table = 'training_videos';

    protected $fillable = ['category_id', 'title', 'description', 'youtube_video_key', 'status', 'created_at', 'updated_at', 'deleted_at', 'user_id'];


     /**
     * Get the  record associated with the statue.
     */
    public function category()
    {
        return $this->hasOne('App\Http\Model\TrainingCategory','id','category_id');
    } 
}
