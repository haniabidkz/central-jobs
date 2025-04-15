<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_category';

    protected $fillable = ['sortname', 'name', 'phonecode'];
    
}
