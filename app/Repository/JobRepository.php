<?php

namespace App\Repository;
use App\Http\Model\JobPost;
use App\Http\Model\State;
use App\Http\Model\Country;
use App\Http\Model\JobApplied;
use App\Http\Model\Skill;
use App\Http\Model\selectedSkill;
use App\Http\Model\PostState;
use App\Http\Model\MasterCmsCategory;
use App\Http\Model\JobpostCmsBasicInfo;
use App\Repository\CommonRepository;
use App\Http\Model\JobPostSpecificQuestions;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Auth;
use App\Http\Model\UserBlock;
use App\Http\Model\UserFollowers;
use App\Jobs\JobAlertNotification;

class JobRepository {

    protected $postState;
    protected $masterCmsCategory;
    protected $jobPost;
    protected $jobPostSpecificQuestions;
    protected $userBlock;
    protected $userFollowers;

    public function __construct(
        MasterCmsCategory $masterCmsCategory,
        PostState $postState,
        JobPost $jobPost,
        JobPostSpecificQuestions $jobPostSpecificQuestions,
        UserBlock $userBlock,
        UserFollowers $userFollowers
        
    ) {
        $this->masterCmsCategory = new CommonRepository($masterCmsCategory);
        $this->postState = new CommonRepository($postState);
        $this->jobPost = new CommonRepository($jobPost);
        $this->jobPostSpecificQuestions = new CommonRepository($jobPostSpecificQuestions);
        $this->userBlock = new CommonRepository($userBlock);
        $this->userFollowers = new CommonRepository($userFollowers);
    }
    /**
     * Get job list
     * @return job
     */
    public function get($request) {
        $data = $request->all();
        $relations = ['user','country','postState','selectedSkill','cmsBasicInfo'];    
        $condition = [['category_id','=',1]];
        $condition1 = '';
        $relationTbl = '';
        if(request()->input('title',false) != false){
            $condition [] = ['title','LIKE','%'.$data['title'].'%'];
        }
        if(request()->input('job_id',false) != false){
            $condition [] = ['job_id','=',$data['job_id']];
        }
        if(request()->input('cntrId',false) != false){
            $condition [] = ['country_id','=',$data['cntrId']];
        } else if(empty($data)){
            $condition [] = ['country_id','=',30]; 
        }
        if(request()->input('start_date',false) != false){
            $filterData['start_date'] = date('Y-m-d',strtotime($data['start_date']));
            $from    = Carbon::parse($filterData['start_date'])
                     ->startOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
            $condition [] = ['start_date','>=',$from];
        } 
        if(request()->input('end_date',false) != false){
            $filterData['end_date'] = date('Y-m-d',strtotime($data['end_date']));
            $to    = Carbon::parse($filterData['end_date'])
                     ->endOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
                     //$to = $to . " 12:59:59";
            $condition [] = ['end_date','<=',$to];
        }
        if(request()->input('status',false) != false){
            $date = date('d-m-Y');
            if($data['status'] == 1){
                $startToday = date('Y-m-d',strtotime($date));
                $startToday    = Carbon::parse($startToday)
                     ->startOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();

                $filterData = date('Y-m-d',strtotime($date));
                $today    = Carbon::parse($filterData)
                        ->endOfDay()        // 2018-09-29 00:00:00.000000
                        ->toDateTimeString();
                        //$to = $to . " 12:59:59";
                $condition [] = ['start_date','<=',$startToday];
                $condition [] = ['end_date','>=',$today];
            }
            if($data['status'] == 2){
                $startToday = date('Y-m-d',strtotime($date));
                $startToday    = Carbon::parse($startToday)
                     ->startOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();

                $filterData = date('Y-m-d',strtotime($date));
                $today    = Carbon::parse($filterData)
                        ->endOfDay()        // 2018-09-29 00:00:00.000000
                        ->toDateTimeString();
                        //$to = $to . " 12:59:59";
                $condition [] = ['start_date','<=',$startToday];
                $condition [] = ['end_date','<',$today];
            }
            if($data['status'] == 3){
                $filterData = date('Y-m-d',strtotime($date));
                $today    = Carbon::parse($filterData)
                        ->startOfDay()        // 2018-09-29 00:00:00.000000
                        ->toDateTimeString();
                        //$to = $to . " 12:59:59";
                $condition [] = ['start_date','>',$today];
            }
           
        }
        
        if(request()->input('state',false) != false){
            $condition1  = [['state_id','=',$data['state']]];
            $relationTbl = 'postState';
        } 
        if(request()->input('company_name',false) != false){
            $condition1  = [['company_name','=',$data['company_name']]];
            $relationTbl = 'user';
        } 
        
        $limit = env('ADMIN_PAGINATION_LIMIT');
        $jobPost = $this->jobPost->getSearchWithRelationAll($condition,$condition1,$limit,$relations,$relationTbl);
        //dd($jobPost);
        return $jobPost;
        //1= job
        // $job = JobPost::where('category_id','=',1)
        //         ->with(['country','postState','selectedSkill','cmsBasicInfo'])
        //         ->orderBy("id","DESC")
        //         ->paginate(env('ADMIN_PAGINATION_LIMIT'));
       
        // return $job;
    }
    /** 
     * Fetch Change status of job
     * @param $jobId
     * @return array $status
    */
    public function changeStatus($jobId,$status)
    {   
        $job = JobPost::where('id',$jobId)
        ->update(['status' => $status]);
        return $job;       
    }

    /**
     * Find a all country list
     * @param array $condition
     * @return country list
     */
    public function findOne($condition) {
        $jobDetail = JobPost::where($condition)->with(['country','selectedSkill','postState','cmsBasicInfo','questions'])->first();
        return $jobDetail;
    }

    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function findAllCountryList() {
        $jobDetail = Country::all()->where('status',1)->toArray();
        return $jobDetail;
    }

    /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function findAllStateList() {
        $jobDetail = State::all();
        return $jobDetail;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function removeJob($jobId, $deleteUserApplied = false)
    {
        $company= JobPost::findOrFail($jobId);
        if($deleteUserApplied == true)
        {
            $totalAppliedJob = $company->totalAppliedJob;
            foreach($totalAppliedJob as $appliedJob)
            {
                $appliedJob->delete();
            }
        }
        $company->delete();
        return $company;       
    }

    public function removeClosedAppliedJobs(){
        $company= JobPost::where('job_status', 2)->whereDate('updated_at',  Carbon::now()->add(1, 'day')->toDateString())->get();
        foreach($company as $c){
            $totalAppliedJob = $c->totalAppliedJob;
            if($totalAppliedJob){
                foreach($totalAppliedJob as $appliedJob)
                {
                    $appliedJob->delete();
                } 
            }
        }
        return true;

    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getStateListById($id='') {
        $states = State::where('country_id',$id)
                        ->orderBy("name","ASC")->get();
        return $states;
    }

    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function searchCountryList($request='') {
        $jobDetail = Country::select("name")
        ->where('status',1)
        ->where("name","LIKE","%{$request->input('query')}%")
        ->get();
        return $jobDetail;
    }

    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function updateDetails($id='',$data=''){
        //dd($data);
        //INSERT SELECTEDSKILL TBL DATA
        if((isset($data['skill'])) && $data['skill'] != null){
            $res=selectedSkill::where('type_id',$id)->delete();
            $insertData = [];
              foreach($data['skill'] as $key=>$val){
    
                if(is_numeric($val) == false){
                    $insertArr = [];
                    $insertArr['name'] = ucwords(trim($val));
                    $insertArr['status'] = 1;
                    $insertId = Skill::create($insertArr);
                    $insertData['skill_id'] = $insertId->id;
                    unset($data['skill'][$key]);
                    array_push($data['skill'],$insertId->id);
                }else{
                    $insertData['skill_id'] = $val;
                }
                $insertData['type'] = 'post';
                $insertData['type_id'] = $id;
                $skillInsert = selectedSkill::create($insertData);
    
              }
            }
        //INSERT STATE TBL DATA
        if((isset($data['state_id'])) && !empty($data['state_id'])){
            $res= postState::where('post_id',$id)->delete();
            foreach($data['state_id'] as $key=>$val){
                $stateData = [];
                $stateData['post_id'] = $id;
                $stateData['state_id'] = $val;
                $state = postState::create($stateData);
            }
        }

        //INSERT Language CMS MASTER CAT TBL DATA
        if((isset($data['language'])) && $data['language'] != null){
            $res = JobpostCmsBasicInfo::where([['post_id',$id],['type','language']])->delete();
            $languageId = '';
            $insertData = [];
                foreach($data['language'] as $key=>$val){
    
                    if(is_numeric($val) == false){
                        $cmsMasterLang = [];
                        $cmsMasterLang['name'] = ucwords(trim($val));
                        $cmsMasterLang['type'] = 'language';
                        $cmsMasterLang = MasterCmsCategory::create($cmsMasterLang);
                        $languageId = $cmsMasterLang->id;
                        unset($data['language'][$key]);
                    }else{
                        $languageId = $val;
                    }
                    $cmsBasicInfoLang = [];
                    $cmsBasicInfoLang['post_id'] = $id;
                    $cmsBasicInfoLang['master_cms_cat_id'] = $languageId;
                    $cmsBasicInfoLang['status'] = 1;
                    $cmsBasicInfoLang['type'] = 'language';
                    $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfoLang);
                }
            }
        //INSERT SENIORTY CMS MASTER CAT TBL DATA
        $seniorityId = '';
        if((isset($data['seniority_other'])) && $data['seniority_other'] != ''){
            $cmsMaster = [];
            $cmsMaster['name'] = ucwords(trim($data['seniority_other']));
            $cmsMaster['type'] = 'seniority';
            //CHk 
            $chk = $this->masterCmsCategory->findSingleRow($cmsMaster);
            if($chk){
                $seniorityId = $chk['id'];
            }else{
                $cmsMaster = $this->masterCmsCategory->create($cmsMaster);
                $seniorityId = $cmsMaster->id;
            }
            
        }else if((isset($data['seniority'])) && $data['seniority'] != '' && $data['seniority'] != 'other'){
            $seniorityId = $data['seniority'];
        }
        if($seniorityId != ''){
            $res = JobpostCmsBasicInfo::where([['post_id',$id],['type','seniority']])->delete();
            $cmsBasicInfo = [];
            $cmsBasicInfo['post_id'] = $id;
            $cmsBasicInfo['master_cms_cat_id'] = $seniorityId;
            $cmsBasicInfo['status'] = 1;
            $cmsBasicInfo['type'] = 'seniority';
            $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfo);
        }

        //INSERT Employment CMS MASTER CAT TBL DATA
        $employmentId = '';
        if((isset($data['employment_other'])) && $data['employment_other'] != ''){
            $cmsMasterEmp = [];
            $cmsMasterEmp['name'] = ucwords(trim($data['employment_other']));
            $cmsMasterEmp['type'] = 'employment_type';
             //CHk 
             $chk = $this->masterCmsCategory->findSingleRow($cmsMasterEmp);
             if($chk){
                 $employmentId = $chk['id'];
             }else{
                $cmsMasterEmp = $this->masterCmsCategory->create($cmsMasterEmp);
                $employmentId = $cmsMasterEmp->id;
             }
        }else if((isset($data['employment'])) && $data['employment'] != '' && $data['employment'] != 'other'){
            $employmentId = $data['employment'];
        }
        if($employmentId != ''){
            $res = JobpostCmsBasicInfo::where([['post_id',$id],['type','employment_type']])->delete();
            $cmsBasicInfoEmp = [];
            $cmsBasicInfoEmp['post_id'] = $id;
            $cmsBasicInfoEmp['master_cms_cat_id'] = $employmentId;
            $cmsBasicInfoEmp['status'] = 1;
            $cmsBasicInfoEmp['type'] = 'employment_type';
            $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfoEmp);
        }
        //SCREENING QUESTIONS
        if((isset($data['screening_1']) && ($data['screening_1'] != '')) || (isset($data['screening_2']) && ($data['screening_2'] != '')) || (isset($data['screening_3']) && ($data['screening_3'] != ''))){
            $res = jobPostSpecificQuestions::where([['post_id',$id],['type',1]])->delete();
        }
        if(isset($data['screening_1']) && ($data['screening_1'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_1'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_2']) && ($data['screening_2'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_2'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_3']) && ($data['screening_3'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_3'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        //INTERVIEW QUESTIONS
        if((isset($data['interview_1']) && ($data['interview_1'] != '')) || (isset($data['interview_2']) && ($data['interview_2'] != '')) || (isset($data['interview_3']) && ($data['interview_3'] != ''))){
            $res = jobPostSpecificQuestions::where([['post_id',$id],['type',2]])->delete();
        }
        if(isset($data['interview_1']) && ($data['interview_1'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_1'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_2']) && ($data['interview_2'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_2'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_3']) && ($data['interview_3'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_3'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }

        //INSERT POST TBL DATA
        $postData = [];
        if(isset($data['title']) && ($data['title'] != '')){
            $slug = $this->getUniqueSlug($data['title']);
            $postData['title'] = $data['title'];
            $postData['slug'] = $slug;
        }
        if(isset($data['country_id']) && ($data['country_id'] != '')){
            $postData['country_id'] = $data['country_id'];
        }
        if(isset($data['city']) && ($data['city'] != '')){
            //$city = implode(",",$data['city']);
            $postData['city'] = $data['city'];
        }

        if(isset($data['type']) && ($data['type'] != '')){
            //$city = implode(",",$data['city']);
            $postData['type'] = $data['type'];
        }
        
        $postData['status'] = 1;
        if(isset($data['user_id']) && ($data['user_id'] != '')){
            $postData['user_id'] = $data['user_id'];
        }else{
            $postData['user_id'] = Auth::user()->id;
        }
        $postData['description'] = $data['description'];
        $postData['start_date'] = $data['start_date'];
        $postData['end_date'] = $data['end_date'];
      //  $postData['applied_by'] = $data['applied_by'];
        $postData['category_id'] = 1;
        $postData['website_link']='';
        if(isset($data['website_link']) && ($data['website_link'] != ''))
        $postData['website_link'] = $data['website_link'];
        // if($data['applied_by'] == 2){
        //     $postData['website_link'] = $data['website_link'];
        // }else{
        //     $postData['website_link'] = '';
        // }
        //$postData['job_id'] = $this->generateJobId();
        $toDay = strtotime(date('Y-m-d')); 
        //dd($toDay);
        $date = date('d-m-Y');
        $endToday = date('Y-m-d',strtotime($date));
        $endToday    = Carbon::parse($endToday)
                ->endOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();
        $endToday = strtotime($endToday);    
             
        if((strtotime($data['start_date']) >= $toDay) && (strtotime($data['start_date']) <= $endToday)){ 
            $postData['job_status'] = 1;
        }else if(strtotime($data['end_date']) < $toDay){ 
            $postData['job_status'] = 2;
        }else if(strtotime($data['start_date']) > $endToday){ 
            $postData['job_status'] = 0;
        }
        $post= JobPost::where('id', $id)->update($postData);

        //GET FOLLOWER AND SEND NOTIFICATIONS FOR NEW JOB
        $cond = [];
        $cond['user_id'] = Auth::user()->id;
        $relation = 'user';
        $whereNotIn = $this->getWhomBlockByMeIds(Auth::user()->id);
        $followers = $this->userFollowers->getAllUnblockFollower($cond,$relation,$whereNotIn,'');
        
        if(!empty($followers)){
            foreach($followers as $key=>$val){
                // $notification = [];
                // $notification['type'] = 'job';
                // $notification['type_id'] = $post->id;
                // $notification['from_user_id'] = $userId;
                // $notification['to_user_id'] = $val['follower_id'];
                // $this->notification->create($notification);

                $whereInArr = [];
                $condition1['status'] = 1;
                $relations = ['company','country','postState','cmsBasicInfo'];
                $whereInField = 'id';
                $whereInArr[0] =  $id;
                $dataMail['job_details'] = $this->jobPost->showWithWhereIn($condition1,$relations,$whereInField,$whereInArr);
                $imgPath = env('APP_URL').'/backend/dist/img/user.png'; 
                $logoPath = env('APP_URL').'/frontend/images/logo-color.png';   
                $dataMail['imgPath'] = $imgPath;
                $dataMail['logoPath'] = $logoPath;
                $conditions[] = ['id','=',1];
                $toUser = $val['user'];
                $dataMail['first_name'] = $toUser['first_name'];
                $dataMail['details']['fromUser']['company_name'] = Auth::user()->company_name;
                $dataMail['details']['toUser'] = $toUser;
                dispatch(new JobAlertNotification($dataMail));
            }
            
        }

        return $post;
    }

    /**
     * Funcion to get candidate's connection's ids
     * @param integer $userId
     * @return array $followingIds
     */
    public function getWhomBlockByMeIds($userId)
    {
       $myBlockIds = [0];
       $conditions = [['blocked_by','=',$userId]];
       $myBlocks = $this->userBlock->getAll($conditions);
       if($myBlocks->isNotEmpty()){
           foreach ($myBlocks as $key => $row) {
                     $myBlockIds[] = $row->blocked_user_id;
           }
       }
       return $myBlockIds;
    }


    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function addDetails($data=''){
        //dd($data);
       //INSERT POST TBL DATA
       $slug = $this->getUniqueSlug($data['title']);
       $postData = [];
       $postData['title'] = $data['title'];
       $postData['slug'] = $slug;
       $postData['country_id'] = $data['country_id'];
       $postData['status'] = 1;
       $postData['user_id'] = $data['user_id'];
       $postData['city'] = $data['city'];
       $postData['description'] = $data['description'];
       $postData['start_date'] = $data['start_date'];
       $postData['end_date'] = $data['end_date'];
       $postData['applied_by'] = $data['applied_by'];
       $postData['category_id'] = 1;
       if($data['applied_by'] == 2){
           $postData['website_link'] = $data['website_link'];
       }else{
           $postData['website_link'] = '';
       }
       $postData['job_id'] = $this->generateJobId();
       $toDay = strtotime(date('Y-m-d')); 

       $date = date('d-m-Y');
        $endToday = date('Y-m-d',strtotime($date));
        $endToday    = Carbon::parse($endToday)
                ->endOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();
        $endToday = strtotime($endToday); 

        if((strtotime($data['start_date']) >= $toDay) && (strtotime($data['start_date']) <= $endToday)){ 
            $postData['job_status'] = 1;
        }else if(strtotime($data['end_date']) < $toDay){ 
            $postData['job_status'] = 2;
        }else if(strtotime($data['start_date']) > $endToday){ 
            $postData['job_status'] = 0;
        }
       $post= JobPost::create($postData);

        //INSERT SELECTEDSKILL TBL DATA
        if((isset($data['skill'])) && $data['skill'] != null){
            $insertData = [];
              foreach($data['skill'] as $key=>$val){
    
                if(is_numeric($val) == false){
                    $insertArr = [];
                    $insertArr['name'] = ucwords(trim($val));
                    $insertArr['status'] = 1;
                    $insertId = Skill::create($insertArr);
                    $insertData['skill_id'] = $insertId->id;
                    unset($data['skill'][$key]);
                    array_push($data['skill'],$insertId->id);
                }else{
                    $insertData['skill_id'] = $val;
                }
                $insertData['type'] = 'post';
                $insertData['type_id'] = $post->id;
                $skillInsert = selectedSkill::create($insertData);
    
              }
            }
        //INSERT STATE TBL DATA
        if(!empty($data['state_id'])){
            foreach($data['state_id'] as $key=>$val){
                $stateData = [];
                $stateData['post_id'] = $post->id;
                $stateData['state_id'] = $val;
                $state = postState::create($stateData);
            }
        }

        //INSERT Language CMS MASTER CAT TBL DATA
        if((isset($data['language'])) && $data['language'] != null){
            $languageId = '';
            $insertData = [];
                foreach($data['language'] as $key=>$val){
    
                    if(is_numeric($val) == false){
                        $cmsMasterLang = [];
                        $cmsMasterLang['name'] = ucwords(trim($val));
                        $cmsMasterLang['type'] = 'language';
                        $cmsMasterLang = MasterCmsCategory::create($cmsMasterLang);
                        $languageId = $cmsMasterLang->id;
                        unset($data['language'][$key]);
                    }else{
                        $languageId = $val;
                    }
                    $cmsBasicInfoLang = [];
                    $cmsBasicInfoLang['post_id'] = $post->id;
                    $cmsBasicInfoLang['master_cms_cat_id'] = $languageId;
                    $cmsBasicInfoLang['status'] = 1;
                    $cmsBasicInfoLang['type'] = 'language';
                    $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfoLang);
                }
            }
        //INSERT SENIORTY CMS MASTER CAT TBL DATA
        $seniorityId = '';
        if((isset($data['seniority_other'])) && $data['seniority_other'] != ''){
            $cmsMaster = [];
            $cmsMaster['name'] = ucwords(trim($data['seniority_other']));
            $cmsMaster['type'] = 'seniority';
            //CHk 
            $chk = $this->masterCmsCategory->findSingleRow($cmsMaster);
            if($chk){
                $seniorityId = $chk['id'];
            }else{
                $cmsMaster = $this->masterCmsCategory->create($cmsMaster);
                $seniorityId = $cmsMaster->id;
            }
            
        }else if((isset($data['seniority'])) && $data['seniority'] != '' && $data['seniority'] != 'other'){
            $seniorityId = $data['seniority'];
        }
        if($seniorityId != ''){
            $cmsBasicInfo = [];
            $cmsBasicInfo['post_id'] = $post->id;
            $cmsBasicInfo['master_cms_cat_id'] = $seniorityId;
            $cmsBasicInfo['status'] = 1;
            $cmsBasicInfo['type'] = 'seniority';
            $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfo);
        }

        //INSERT Employment CMS MASTER CAT TBL DATA
        $employmentId = '';
        if((isset($data['employment_other'])) && $data['employment_other'] != ''){
            $cmsMasterEmp = [];
            $cmsMasterEmp['name'] = ucwords(trim($data['employment_other']));
            $cmsMasterEmp['type'] = 'employment_type';
             //CHk 
             $chk = $this->masterCmsCategory->findSingleRow($cmsMasterEmp);
             if($chk){
                 $employmentId = $chk['id'];
             }else{
                $cmsMasterEmp = $this->masterCmsCategory->create($cmsMasterEmp);
                $employmentId = $cmsMasterEmp->id;
             }
        }else if((isset($data['employment'])) && $data['employment'] != '' && $data['employment'] != 'other'){
            $employmentId = $data['employment'];
        }
        if($employmentId != ''){
            $cmsBasicInfoEmp = [];
            $cmsBasicInfoEmp['post_id'] = $post->id;
            $cmsBasicInfoEmp['master_cms_cat_id'] = $employmentId;
            $cmsBasicInfoEmp['status'] = 1;
            $cmsBasicInfoEmp['type'] = 'employment_type';
            $cmsMaster = JobpostCmsBasicInfo::create($cmsBasicInfoEmp);
        }
        //SCREENING QUESTIONS
        if(isset($data['screening_1']) && ($data['screening_1'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $post->id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_1'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_2']) && ($data['screening_2'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $post->id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_2'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_3']) && ($data['screening_3'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $post->id;
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_3'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        //INTERVIEW QUESTIONS
        if(isset($data['interview_1']) && ($data['interview_1'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $post->id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_1'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_2']) && ($data['interview_2'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $post->id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_2'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_3']) && ($data['interview_3'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $post->id;
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_3'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }

        
        return $post;
    }
    /*
     @DevelopedBy: Iumpa
     @Date: 29/03/2020
     @function to genrate job id
     */
    public function generateJobId()
    {
        $jobId = 'MRHJOB'.time();
        return $jobId;
    }
    /**
     * Function to get all slug from table
     * @param string $slugString
     * @return array $allSlug
     */
    public function getAllSlug($slugString='') 
    {        
        $condition [] = ['slug','LIKE',$slugString.'%'];
        return $this->jobPost->getAll($condition);
    }
    /**
     * Function to generate unique slug
     * @param string $stringToSlug
     * @return string $slug
     */
    public function getUniqueSlug($stringToSlug)
    {
       $slug = $stringToSlug;
      
        //$slug = preg_replace(pattern, replacement, subject)
        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($slug)));
        $resultSet = $this->getAllSlug($slug);         
        if($resultSet->isNotEmpty())
        {
             $total_row = $resultSet->count();
             if($total_row > 0)
             {
                  $result = $resultSet->toArray();
                  foreach($result as $row)
                  {
                       $data[] = $row['slug'];
                  }
                  
                  if(in_array($slug, $data))
                  {
                       $count = 0;
                       while( in_array( ($slug . '-' . ++$count ), $data) );
                       $slug = strtolower($slug . '-' . time());
                  }
             }
        }
        return $slug;        
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function getAllUserApplied($jobId='',$search=''){
        $users = JobApplied::where([['job_id',$jobId],['applied_status',2]])->with(['user','jobPost','appliedUserInfo']);
        if($search != ''){
            $users = $users->whereHas('user',function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('email','like', '%'.$search.'%');
            });
        }
        $users = $users->orderBy("id","DESC")
        ->paginate(env('ADMIN_PAGINATION_LIMIT'));
        //dd($users);
        return $users;
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function getAllJobByUser($search='',$userId=''){
        $jobs = JobPost::where('user_id',$userId)->with(['country','state','totalAppliedJob','user']);
        if($search != ''){
            $jobs = $jobs->whereHas('jobPost',function($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                ->orWhere('skill','like', '%'.$search.'%');
            });
        }
        $jobs = $jobs->orderBy("id","DESC")
        ->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $jobs;
    }

    public function getJobCount($condition=''){
        if($condition != ''){
            $list = JobPost::where($condition)->get();
            return $listCount = $list->count();
        }else{
            $list = JobPost::get();
            return $listCount = $list->count();
        }
        
    }
}