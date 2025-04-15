<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class JobPostSpecificQuestions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_post_specific_questions';

    protected $fillable = ['post_id', 'type', 'question', 'mandatory_setting', 'status', 'created_at', 'updated_at', 'deleted_at'];

    
}
