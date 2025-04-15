<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'skills';

     protected $fillable = ['name', 'status', 'created_at', 'updated_at', 'deleted_at'];

}
