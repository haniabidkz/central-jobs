<?php
namespace App\Repository;
use App\Http\Model\JobPost;
use App\Http\Model\State;
use App\Http\Model\Country;
use App\Http\Model\JobApplied;
use App\Http\Model\Upload;
use App\Http\Model\PostCategory;
use App\Http\Model\Skill;
use App\Http\Model\User;
use App\Http\Model\selectedSkill;
use Illuminate\Support\Collection;
use App\Http\Model\UserProfessionalInfo;

class PostRepository {

    /**
     * Get post list
     * @return post
     */
    public function get() {
        // 1 for job category
        $post = JobPost::where('category_id', '!=' ,1)
                ->with(['upload','user','postCategory'])
                ->orderBy("id","DESC")
                ->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $post;
    }
    /**
     * Find a all post list
     * @param array $condition
     * @return country list
     */
    public function findOne($condition) {
        $postDetail = JobPost::where($condition)->with(['upload','user','country','state','postCategory','selectedSkill'])->first()->toArray();
        //dd($postDetail);
        return $postDetail;
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function updateDetails($id='',$data='',$upload=''){
        if(!empty($data['skill'])){
            $res=selectedSkill::where('type_id',$id)->delete();
            $dataSkill = [];
            foreach($data['skill'] as $key=>$val){
                $dataSkill['skill_id'] = $val;
                $dataSkill['type'] = 'post';
                $dataSkill['type_id'] = $id;
                $skill = selectedSkill::create($dataSkill);
            }
            unset($data['skill']);
        }

        if(!empty($upload)){
            $updateData = Upload::where('type_id', $id)->update($upload);
        }
        $post = JobPost::where('id', $id)->update($data);
        
        return $post;
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return post list
     */
    public function postAdd($data = '',$dataForUpload = ''){

        $post = JobPost::create($data);
        if(!empty($data['skill'])){
            $dataSkill = [];
            foreach($data['skill'] as $key=>$val){
                $dataSkill['skill_id'] = $val;
                $dataSkill['type'] = 'post';
                $dataSkill['type_id'] = $post->id;
                $skill = selectedSkill::create($dataSkill);
            }
        }
        if(!empty($dataForUpload)){
            $dataForUpload['type_id'] = $post->id;
            $upload = Upload::create($dataForUpload);
        }
        return $post;
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return post list
     */
    public function UploadAdd($data = ''){
        $upload = Upload::create($data);
        return $upload;
    }
    /**
     * Get post list
     * @return post
     */
    public function getCategoryList() {
        $post = PostCategory::orderBy("id","ASC")->pluck('title', 'id')->all();
        return $post;
    }
    /**
     * Get post list
     * @return post
     */
    public function getSkillList() {
        $post = Skill::orderBy("id","ASC")->pluck('name', 'id')->all();
        return $post;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function changeStatus($request)
    {
        $updateData = [];
        if($request['status'] == 0){
            $updateData['status'] = 1;
        }else{
            $updateData['status'] = 0;
        }
        $postId = $request['id'];
        $post = JobPost::where('id',$postId)->update($updateData);
        return $post;       
    }
     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCompanyList() {
        $company = User::select('company_name')
                        ->distinct()
                        ->where('company_name','!=', '')
                        ->get()
                        ->toArray();
        return $company;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCompanyListArray() {
        $company = User::all()
                        ->where('user_type',3)
                        ->where('company_name','!=','')
                        ->where('status',1);

                        $company = collect($company);
                        $company = $company->unique('company_name')->all();    
        return $company;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getUserProfInfoArray() {
        $company = UserProfessionalInfo::whereNotNull('company_name')->groupBy('company_name')->where(['status'=>1])->orderBy("id","ASC")->get()->toArray();
        
        return $company;
        
    }

}