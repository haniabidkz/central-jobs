<?php
namespace App\Repository\Candidate;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailBlockedUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\UserPostLike;
use App\Http\Model\JobPost;
use App\Http\Model\JobApplied;
use App\Http\Model\CommonComment;

class CandidateRepository {

   
    /**
     * Get ambassador list
     * @return ambassadors
     */
    public function get($search = '') {
        $candidate = User::where('user_type',2)->with('country','state','profile','appliedJob','currentCompany');
        if((isset($search['name'])) && ($search['name'] != null)){
            $candidate = $candidate->where('first_name','like','%'.base64_encode($search['name']).'%');
        }
        if((isset($search['company_name'])) && ($search['company_name'] != null)){
            $currentComp = $search['company_name'];
            $candidate = $candidate->whereHas('currentCompany',function($q) use ($currentComp) {
                $q->where('currently_working_here',1)
                ->where('company_name',$currentComp);
            });
        }
        if((isset($search['email'])) && ($search['email'] != null)){
            $candidate = $candidate->where('email',base64_encode($search['email']));
        }
        if((isset($search['cntrId'])) && ($search['cntrId'] != null)){
            $candidate = $candidate->where('country_id',$search['cntrId']);
        }
        if((isset($search['state'])) && ($search['state'] != null)){
            $candidate = $candidate->where('state_id',$search['state']);
        }
        if((isset($search['status'])) && ($search['status'] != null)){
            if($search['status'] == 3){
                $search['status'] = 0;
            }
            $candidate = $candidate->where('status',$search['status']);
        }
        $candidate = $candidate->orderBy("id","DESC")
        ->paginate(env('ADMIN_PAGINATION_LIMIT'));
        //dd($candidate);
        return $candidate;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function removeCandidate($candidateId)
    {

        $post = JobPost::where('user_id', $candidateId)->get();
        if(!empty($post)){
            foreach($post as $key=>$val){
                 JobApplied::where('job_id', $val['id'])->delete();
                 UserPostLike::where('post_id', $val['id'])->delete();
                 CommonComment::where('type_id', $val['id'])->delete();
            }
        }
        
        JobApplied::where('user_id', $candidateId)->delete();
        UserPostLike::where('user_id', $candidateId)->delete();
        CommonComment::where('user_id', $candidateId)->delete();
        JobPost::where('user_id', $candidateId)->delete();

        $candidate= User::findOrFail($candidateId);
        $candidate->delete();
        
        return $candidate;       
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function changeStatus($request)
    {
        $updateData = [];
        $candidateId = $request['id'];
        if($request['status'] == 0){
            $updateData['status'] = $request['status'];
            $updateData['block_reason'] = $request['reason'];
            $post = JobPost::where('user_id', $candidateId)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 0]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 0]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 0]);
                }
            }
            
            JobApplied::where('user_id', $candidateId)->update(['status' => 0]);
            UserPostLike::where('user_id', $candidateId)->update(['status' => 0]);
            CommonComment::where('user_id', $candidateId)->update(['status' => 0]);
            JobPost::where('user_id', $candidateId)->update(['status' => 0]);
        }else{
            $updateData['status'] = $request['status'];
            $post = JobPost::where('user_id', $candidateId)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                    JobApplied::where('job_id', $val['id'])->update(['status' => 1]);
                    UserPostLike::where('post_id', $val['id'])->update(['status' => 1]);
                    CommonComment::where('type_id', $val['id'])->update(['status' => 1]);
                }
            }
            
            JobApplied::where('user_id', $candidateId)->update(['status' => 1]);
            UserPostLike::where('user_id', $candidateId)->update(['status' => 1]);
            CommonComment::where('user_id', $candidateId)->update(['status' => 1]);
            JobPost::where('user_id', $candidateId)->update(['status' => 1]);
        }
        
        $candidate = User::where('id',$candidateId)
        ->update($updateData);
        if($candidate != NULL && $request['status'] == 0){
            $userDetail = User::where('id',$candidateId)->first();
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png';
            $userDetail['logoPath'] = env('APP_URL').'public/frontend/images/logo-color.png';
            $admin = Auth::user()->email;
            dispatch(new SendEmailBlockedUser($userDetail,$imgPath,$admin));
        }
        return $candidate;       
    }
     /**
     * Find a candidate details
     * @param array $id
     * @return  user details
     */
    public function findOne($id='') {
        $userDetail = User::where('id',$id)->with(['country','state','profile'])->first();
        return $userDetail;
    }

    public function getCandidateCount($condition){
        $list = User::where($condition)->get();
        return $listCount = $list->count();
    }
   

}