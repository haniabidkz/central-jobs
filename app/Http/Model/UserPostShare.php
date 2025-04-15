<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserPostShare extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_post_shares';

    protected $fillable = ['user_id', 'post_id', 'reference_post_id', 'status', 'created_at', 'updated_at', 'deleted_at'];

    public function post()
    {
        return $this->belongsTo('App\Http\Model\JobPost','reference_post_id','id')->where('status',1)->with('user','country','postState','company','upload','cmsBasicInfo','reportedPost');
    }
}
