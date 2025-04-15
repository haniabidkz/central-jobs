<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class selectedSkill extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'selected_skills';

    protected $fillable = ['skill_id', 'type_id', 'type', 'created_at', 'updated_at', 'deleted_at'];

    public function skill()
    {
        return $this->hasOne('App\Http\Model\Skill','id','skill_id');
    } 

}
