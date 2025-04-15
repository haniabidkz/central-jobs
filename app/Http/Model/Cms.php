<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms';

    protected $fillable = ['title', 'description','meta_title','meta_desc'];

    
}
