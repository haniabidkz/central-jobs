<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class JobpostCmsBasicInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobpost_cms_basic_info';

    protected $fillable = ['post_id', 'master_cms_cat_id', 'status', 'type',  'created_at', 'updated_at', 'deleted_at'];
    
     /**
     * Get the phone record associated with the user.
     */
    public function masterInfo()
    {
        return $this->belongsTo('App\Http\Model\MasterCmsCategory','master_cms_cat_id','id');
    }  
}
