<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CmsBasicInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_cms_basic_info';

    protected $fillable = ['user_id', 'master_cms_cat_id', 'status', 'type', 'fluency_lang_id', 'created_at', 'updated_at', 'deleted_at'];
    
    public function hobby()
    {
        return $this->belongsTo('App\Http\Model\MasterCmsCategory','master_cms_cat_id')->where('type','=', 'hobbies');
    }
    public function language()
    {
        return $this->belongsTo('App\Http\Model\MasterCmsCategory','master_cms_cat_id')->where('type','=', 'language')->with('fluency');
    }

    public function fluencyLabel()
    {
        return $this->belongsTo('App\Http\Model\MasterCmsCategory','master_cms_cat_id')->where('type','=', 'proficiency');
    }
    
}
