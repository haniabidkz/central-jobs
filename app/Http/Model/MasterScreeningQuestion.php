<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MasterScreeningQuestion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_screening_questions';

    protected $fillable = ['question', 'status', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    /* Get the phone record associated with the profile.
    */
    public function multiLangualQuestion()
    {
        return $this->hasMany('App\Http\Model\MultiLanguageScreeningQuestion','master_screening_questions_id','id');
    }  

    /* Get the phone record associated with the profile.
    */
    public function answerOptions()
    {
        return $this->hasMany('App\Http\Model\ScreeningAnswerOption','master_screening_questions_id','id');
    } 
    
}
