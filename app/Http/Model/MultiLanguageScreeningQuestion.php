<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MultiLanguageScreeningQuestion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'multi_language_screening_questions';

    protected $fillable = ['master_screening_questions_id', 'language', 'question', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
}
