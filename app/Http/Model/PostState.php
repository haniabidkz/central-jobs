<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PostState extends Model
{   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_state';

    protected $fillable = ['post_id', 'state_id', 'created_at', 'updated_at', 'deleted_at'];
    /**
     * Get the  record associated with the statue.
     */
    public function state()
    {
        return $this->hasOne('App\Http\Model\State','id','state_id');
    }   
    

}
