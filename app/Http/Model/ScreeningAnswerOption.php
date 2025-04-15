<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ScreeningAnswerOption extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'screening_answer_options';

    protected $fillable = ['master_screening_questions_id', 'language', 'option_one', 'option_two', 'option_three', 'reason_one', 'reason_two', 'reason_three', 'answer', 'created_at', 'updated_at', 'deleted_at'];
    
}
