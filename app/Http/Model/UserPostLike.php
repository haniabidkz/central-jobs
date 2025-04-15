<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPostLike extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_post_likes';

    protected $fillable = ['post_id', 'user_id','status','created_at', 'updated_at', 'deleted_at'];


}
