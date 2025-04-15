<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Http\Model\User;

class MasterCmsCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_cms_category';

    protected $fillable = ['name', 'type', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
    public function fluency()
    {
        $slug = collect(request()->segments())->last() ;
        $user = User::where([['slug','=',$slug]])->first();
            
        if(!empty($user)){
            $user_id = $user['id'];
        }
        else if (Auth::check())
        {
            if(Auth::user()->id == 1){
                $id = collect(request()->segments())->last() ;
                $user_id = decrypt($id);
            }else{
                $user_id = Auth::user()->id;
            }
            
        }
        
        return $this->hasOne('App\Http\Model\CmsBasicInfo','fluency_lang_id')->where([['type','=', 'proficiency_info'],['user_id','=',$user_id]])->with('fluencyLabel');
    }
}
