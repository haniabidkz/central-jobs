<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PageContentText extends Model
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
    protected $table = 'page_content_text';

    protected $fillable = ['type', 'language_type', 'page_contents_id', 'text', 'created_at', 'updated_at', 'deleted_at', 'status'];
    

    /**
     * Get the page contents
     */
    public function pageContent()
    {        
        return $this->belongsTo('App\Http\Model\PageContents','page_contents_id')->with('pageInfo');
    } 

}
