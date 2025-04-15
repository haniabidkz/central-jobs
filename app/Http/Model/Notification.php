<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    protected $fillable = ['type', 'type_id', 'from_user_id', 'to_user_id','seen_status','redirect_link','status','created_at','updated_at','deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Http\Model\User','from_user_id','id')->withTrashed()->with('profileImage');
    }
    public function message()
    {
        return $this->belongsTo('App\Http\Model\Message','type_id','id');
    }
    public function post()
    {
        return $this->belongsTo('App\Http\Model\JobPost','type_id','id')->where('status',1);
    }

}
