<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ScreeningUserAnswer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'screening_user_answer';

    protected $fillable = ['user_id', 'master_screening_questions_id', 'answer_option', 'created_at', 'updated_at', 'deleted_at'];
    
}
