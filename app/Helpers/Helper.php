<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Auth;
use App\Service\PostService;
use App\Http\Model\UserConnection;
use App\Http\Model\User;
use App\Http\Model\UserProfessionalInfo;
use App\Http\Model\UserBlock;
use App\Http\Model\JobPost;
use App\Http\Model\JobApplied;
use App\Http\Model\UserFollowers;


class Helper
{

    public static function mutualFrnds($userId='')
    {
        $authId = Auth::user()->id;
        
        $acceptBy = UserConnection::where([['request_accepted_by',$authId],['status',1]])->pluck('request_sent_by')->all();
        $sentBy = UserConnection::where([['request_sent_by',$authId],['status',1]])->pluck('request_accepted_by')->all();
        $loginUsersFrnd = array_unique (array_merge ($acceptBy, $sentBy));
       

        $acceptByUser = UserConnection::where([['request_accepted_by',$userId],['status',1]])->pluck('request_sent_by')->all();
        $sentByUser = UserConnection::where([['request_sent_by',$userId],['status',1]])->pluck('request_accepted_by')->all();
        $usersFrnd = array_unique (array_merge ($acceptByUser, $sentByUser));

        $mutualFrnds = array_intersect($loginUsersFrnd, $usersFrnd);
        return count($mutualFrnds);

    }

    public static function connectedFrndsImage($company='')
    {
        $authId = Auth::user()->id;
        
        $acceptBy = UserConnection::where([['request_accepted_by',$authId],['status',1]])->pluck('request_sent_by')->all();
        $sentBy = UserConnection::where([['request_sent_by',$authId],['status',1]])->pluck('request_accepted_by')->all();
        $loginUsersFrnd = array_unique (array_merge ($acceptBy, $sentBy));
       
        $user = UserProfessionalInfo::whereIn('user_id',$loginUsersFrnd)->where('company_name',$company)->with('user')->get();
        return $user;

    }
    public static function chkUserBlockByMe($userId='')
    {
        $authId = Auth::user()->id;
        
        $blockData = UserBlock::where([['blocked_user_id',$userId],['blocked_by',$authId]])->get()->toArray();
        
        return $blockData;

    }
    public static function checkBlockUser($userId='')
    {
        $authId = Auth::user()->id;
        
        $blockData = UserBlock::where([['blocked_user_id',$authId],['blocked_by',$userId]])->orWhere([['blocked_by',$authId],['blocked_user_id',$userId]])->get()->toArray();
        
        return $blockData;

    }
    public static function chkJobExist($jobId){
        $jobDetails = JobPost::where([['id',$jobId],['status',1]])->get()->first();
        return $jobDetails;
    }

    public static function getAppliedCandidateCount($jobId='')
    {
        $authId = Auth::user()->id;
        $myBlockIds = [0];
        $conditions = [['blocked_user_id','=',$authId]];
        $myBlocks = UserBlock::where($conditions)->get();
        
        if($myBlocks->isNotEmpty()){
            foreach ($myBlocks as $key => $row) {
                $myBlockIds[] = $row->blocked_by;
            }
        }
        $notInId = $myBlockIds;
        $data = JobApplied::where([['job_id',$jobId],['applied_status',2]])->whereNotIn('user_id',$notInId)->with('user');
        $data = $data->whereHas('user',function($q) {
            $q->where('status',1);
        });
        $count = $data->get()->count();
        return $count;

    }

    public static function getFollowerCount($userId =''){
        $condition = [['user_id',$userId]];
        $relations = ['user'];
        $myBlockIds = [0];
        $conditions = [['blocked_user_id','=',$userId]];
        $myBlocks = UserBlock::where($conditions)->get();
        if($myBlocks->isNotEmpty()){
            foreach ($myBlocks as $key => $row) {
                        $myBlockIds[] = $row->blocked_by;
            }
        }
        $notInId = $myBlockIds;
        $wherHasTbl = 'user';
        $wherHasCon = [['status',1]];
        $followers = UserFollowers::where($condition)
                                    ->whereNotIn('follower_id',$notInId);
        $followers = $followers->whereHas($wherHasTbl,function($q) use ($wherHasCon) {
            $q->where($wherHasCon);
        }); 
        $followers = $followers->with($relations)->orderBy('id',"desc")->get()->count();                          
        //dd($followers);
        return $followers;
    }
   
}