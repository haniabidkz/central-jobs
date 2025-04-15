<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $fillable = ['user_from_id', 'user_to_id','blocked_by','blocked_to','message','status','created_at','updated_at','deleted_at'];

    public function userFrom()
    {
        return $this->belongsTo('App\Http\Model\User','user_from_id', 'id');
    }
    public function userTo()
    {
        return $this->belongsTo('App\Http\Model\User','user_to_id','id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Http\Model\Upload','type_id')->where('type','=', 'message');
    }

}
