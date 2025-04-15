<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class PageContents extends Model
{
    //use SoftDeletes;
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
    protected $table = 'page_contents';

    protected $fillable = ['page_id', 'content_ref','status','created_at', 'updated_at', 'deleted_at'];
    

    /**
     * Get the page contents
     */
    public function pageInfo()
    {        
        return $this->belongsTo('App\Http\Model\Page','page_id')->where('status',1)->with('bannerImage');
    } 
    public function pageText(){
        return $this->hasMany('App\Http\Model\PageContentText','page_contents_id');
    }

}
