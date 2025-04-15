<?php
namespace App\Repository\Company;
use App\User;
use App\Http\Model\Profile;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailValidateUser;
use App\Jobs\SendEmailBlockedUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\UserPostLike;
use App\Http\Model\JobPost;
use App\Http\Model\JobApplied;
use App\Http\Model\CommonComment;
use App\Http\Model\ReportedPost;

class CompanyRepository {
   
    /**
     * Get ambassador list
     * @return ambassadors
     */
    public function get($search = '') {
        $company = User::where('user_type',3)->with('country','state','job','profile');
        if((isset($search['name'])) && ($search['name'] != null)){
           // dd($search['name']);
            $company = $company->where('first_name','Like','%'.trim($search['name']).'%');
        }
        if((isset($search['company_name'])) && ($search['company_name'] != null)){
            $company = $company->where(DB::raw('company_name'),'Like','%'.trim($search['company_name']).'%');
        }
        if((isset($search['email'])) && ($search['email'] != null)){
            $company = $company->where('email',$search['email']);
        }
        if((isset($search['cntrId'])) && ($search['cntrId'] != null)){
            $company = $company->where('country_id',$search['cntrId']);
        }
        if((isset($search['state'])) && ($search['state'] != null)){
            $company = $company->where('state_id',$search['state']);
        }
        if((isset($search['status'])) && ($search['status'] != null)){
            if($search['status'] == 3){
                $search['status'] = 0;
            }
            $company = $company->where('status',$search['status']);
        }
        if((isset($search['approve_status'])) && ($search['approve_status'] != null)){
            if($search['approve_status'] == 3){
                $search['approve_status'] = 0;
            }
            $searchTerm = $search['approve_status'];
            //$company = $company->where('approve_status',$search['approve_status']);
            $company = $company->whereHas('profile', function($query) use($searchTerm){
                $query->where('approve_status',$searchTerm);
            });
            
        }
        $company = $company->orderBy("id","DESC")
        ->withTrashed()
        ->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $company;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function removeCompany($companyId)
    {
        $post = JobPost::where('user_id', $companyId)->withTrashed()->get();
        if(!empty($post)){
            foreach($post as $key=>$val){
                 JobApplied::where('job_id', $val['id'])->forceDelete();
                 UserPostLike::where('post_id', $val['id'])->forceDelete();
                 CommonComment::where('type_id', $val['id'])->forceDelete();
            }
        }
        
        /* JobApplied::where('user_id', $companyId)->delete();
        UserPostLike::where('user_id', $companyId)->delete();
        CommonComment::where('user_id', $companyId)->delete(); */
        JobPost::where('user_id', $companyId)->forceDelete();
        Profile::where('user_id', $companyId)->forceDelete();
        $company= User::withTrashed()->findOrFail($companyId);
        $company->forceDelete();
        
        return $company;       
    }
    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function changeStatus($request)
    {
        $updateData = [];
        $compId = $request['id'];
        if($request['status'] == 0){
            $updateData['status'] = $request['status'];
            $updateData['block_reason'] = $request['reason'];

            $post = JobPost::where('user_id', $compId)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 0]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 0]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 0]);
                }
            }
            
            JobApplied::where('user_id', $compId)->update(['status' => 0]);
            UserPostLike::where('user_id', $compId)->update(['status' => 0]);
            CommonComment::where('user_id', $compId)->update(['status' => 0]);
            JobPost::where('user_id', $compId)->update(['status' => 0]);

            //COMPANY REPORT LIST
            $userId = $compId;
            $condi = [['type_id',$userId],['status',0],['type','company']];
            $reports = ReportedPost::where($condi)->get();
            if(!empty($reports)){
                foreach($reports as $key=>$val1){
                    ReportedPost::where('id', $val1['id'])->update(['status' => 1]);
                }
            }
            

        }else{
            $updateData['status'] = $request['status'];
            $post = JobPost::where('user_id', $compId)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 1]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 1]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 1]);
                }
            }
            
            JobApplied::where('user_id', $compId)->update(['status' => 1]);
            UserPostLike::where('user_id', $compId)->update(['status' => 1]);
            CommonComment::where('user_id', $compId)->update(['status' => 1]);
            JobPost::where('user_id', $compId)->update(['status' => 1]);
        }

        $company = User::where('id',$compId)->update($updateData);
        if(($company != NULL) && ($request['status'] == 0)){
            $userDetail = User::where('id',$compId)->first();
            $userDetail['logoPath'] = env('APP_URL').'public/frontend/images/logo-color.png';
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png';
            $admin = Auth::user()->email;
            dispatch(new SendEmailBlockedUser($userDetail,$imgPath,$admin));
        }
        return $company;       
    }

    /**
     * Find a company details
     * @param array $id
     * @return country list
     */
    public function findOne($id='') {
        $userDetail = User::where('id',$id)->with(['country','state','profile'])->first();
        return $userDetail;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function approveStatus($request)
    {
        $admin = '';
        $id = $request['id'];
        
        $reason = '';
        $updateData = [];
        $updateData['approve_status'] = $request['status'];
        if($request['reason'] != ''){
            $updateData['reason'] = $request['reason'];
            $post = JobPost::where('user_id', $id)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 0]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 0]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 0]);
                }
            }
            
            JobApplied::where('user_id', $id)->update(['status' => 0]);
            UserPostLike::where('user_id', $id)->update(['status' => 0]);
            CommonComment::where('user_id', $id)->update(['status' => 0]);
            JobPost::where('user_id', $id)->update(['status' => 0]);
        }
        $company = Profile::where('user_id',$id)->update($updateData);
        if($request['status'] == 1){
            $post = JobPost::where('user_id', $id)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 1]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 1]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 1]);
                }
            }
            
            JobApplied::where('user_id', $id)->update(['status' => 1]);
            UserPostLike::where('user_id', $id)->update(['status' => 1]);
            CommonComment::where('user_id', $id)->update(['status' => 1]);
            JobPost::where('user_id', $id)->update(['status' => 1]);
        }

        if($company != NULL){
            
            $userDetail = User::where('id',$id)->with('profile')->first();
            $userDetail['logoPath'] = env('APP_URL').'public/frontend/images/logo-color.png';
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png';
            
            $admin = Auth::user()->email;
            
            if($request['reason'] != ''){
                $reason = $request['reason'];
            }
            $n = new SendEmailValidateUser($userDetail,$imgPath,$reason,$admin);
        }
        
        return $company;       
    }

    public function getCandidateCount($condition){
        $list = User::where($condition)->get();
        return $listCount = $list->count();
    }
    public function getCompanyCount($condition){
        $list = User::where($condition)->get();
        return $listCount = $list->count();
    }

    public function getPendingCompanyCount(){
        $searchTerm = 0;
        $company = User::where('user_type',3)->with('profile');
        $company = $company->whereHas('profile', function($query) use($searchTerm){
                $query->where('approve_status',$searchTerm);
        });
        return $company = $company->count();    
    }
}