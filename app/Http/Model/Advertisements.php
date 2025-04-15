<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Advertisements extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advertisements';

    protected $fillable = ['image_name', 'url', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
}
