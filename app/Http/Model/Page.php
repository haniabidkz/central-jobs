<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
   // use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = ['page_name','banner_image_upload_id', 'status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the page contents
     */
    public function pageContents()
    {
        return $this->hasMany('App\Http\Model\PageContents','page_id');
    } 
    /**
     * Get the page contents
     */
    public function upload()
    {
        return $this->belongsTo('App\Http\Model\Upload','banner_image_upload_id')->where('type','cms');
    } 
    public function bannerImage(){
        return $this->hasOne('App\Http\Model\Upload','type_id','id')->where('type','cms');
    }
    public function pageContentRef(){
        return $this->hasMany('App\Http\Model\PageContents','page_id')->with('pageText');
    }

}
