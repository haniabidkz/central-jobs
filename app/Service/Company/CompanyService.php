<?php
namespace App\Service\Company;
use DB;
use Auth;
use File;
use Image;
use Response;
use Carbon\Carbon;
use App\Http\Model\User;
use App\Http\Model\Skill;
use App\Http\Model\Upload;
use App\Http\Model\JobPost;
use App\Http\Model\Profile;
use App\Http\Model\PostState;
use App\Http\Model\UserBlock;
use App\Http\Model\JobApplied;
use App\Service\UploadService;
use App\Http\Model\BlockMessage;
use App\Http\Model\Notification;
use App\Http\Model\ReportedPost;
use App\Http\Model\UserPostLike;
use App\Http\Model\CommonComment;
use App\Http\Model\selectedSkill;
use App\Http\Model\UserFollowers;
use App\Http\Model\UserPostShare;
use App\Http\Model\UserConnection;
use App\Jobs\JobAlertNotification;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Log;
use App\Repository\CommonRepository;
use Illuminate\Support\Facades\Mail;
use App\Http\Model\MasterCmsCategory;
use App\Http\Model\JobpostCmsBasicInfo;
use App\Mail\CommentReportNotification;
use App\Http\Model\JobPostSpecificQuestions;
use App\Repository\Company\CompanyRepository;

class CompanyService {
    
    protected $companyRepo;
    protected $userRepo;
    protected $userFollowers;
    protected $user;
    protected $profile;
    protected $uploadService;
    protected $upload;
    protected $commonComment;
    protected $reportedPost;
    protected $masterCmsCategory;
    protected $jobPost;
    protected $postState;
    protected $selectedSkill;
    protected $skill;
    protected $jobpostCmsBasicInfo;
    protected $jobPostSpecificQuestions;
    protected $notification;
    protected $userBlock;
    protected $userPostShare;
    
    /**
     * @param CompanyRepository $candidateRepo reference to ambasadorRepo
     * @param UserRepository $userRepo reference to userRepo
     * 
     */
    public function __construct(
        CompanyRepository $companyRepo,
        UserRepository $userRepo,
        UserFollowers $userFollowers,
        User $user,
        Profile $profile,
        UploadService $uploadService,
        Upload $upload,
        CommonComment $commonComment,
        ReportedPost $reportedPost,
        MasterCmsCategory $masterCmsCategory,
        JobPost $jobPost,
        PostState $postState,
        selectedSkill $selectedSkill,
        Skill $skill,
        JobpostCmsBasicInfo $jobpostCmsBasicInfo,
        JobPostSpecificQuestions $jobPostSpecificQuestions,
        Notification $notification,
        UserBlock $userBlock,
        UserPostShare $userPostShare
    ) {
        $this->companyRepo = $companyRepo;
        $this->userRepo = $userRepo;
        $this->userFollowers = new CommonRepository($userFollowers);
        $this->user = new CommonRepository($user);
        $this->uploadRepository = new CommonRepository($upload);
        $this->commonCommentRepository = new CommonRepository($commonComment);
        $this->reportedPostRepository = new CommonRepository($reportedPost);
        $this->uploadService = $uploadService;
        $this->profile = new CommonRepository($profile);
        $this->masterCmsCategory = new CommonRepository($masterCmsCategory);
        $this->jobPost = new CommonRepository($jobPost);
        $this->postState = new CommonRepository($postState);
        $this->selectedSkill = new CommonRepository($selectedSkill);
        $this->skill = new CommonRepository($skill);
        $this->jobpostCmsBasicInfo = new CommonRepository($jobpostCmsBasicInfo);
        $this->jobPostSpecificQuestions = new CommonRepository($jobPostSpecificQuestions);
        $this->notification = new CommonRepository($notification);
        $this->userBlock = new CommonRepository($userBlock);
        $this->userPostShare = new CommonRepository($userPostShare);
    }

    /** 
     * Get All Company List
    */
    public function fetchList($search='') {
        return $this->companyRepo->get($search);
    }

    /** 
     * Get All Company List
    */
    public function details($id='') {
        return $this->companyRepo->findOne($id);
    }

    /**
     * Function to get candidate's all followers
     * @param string $userid
     * @return array obj $followers
     */
    public function getFollowers($userId =''){
        $condition = [['user_id',$userId]];
        $relations = ['user'];
        $notInId = $this->getWhoBlockMeIds($userId);
        $wherHasTbl = 'user';
        $wherHasCon = [['status',1]];
        $followers = $this->userFollowers->getWithCondition($condition,'',$relations,$wherHasTbl,$wherHasCon,$notInId);
        //dd($followers);
        return $followers;
    }

    /**
     * Function to get candidate's all followers
     * @param string $userid
     * @return array obj $followers
     */
    public function getFollowersList($userId =''){
        $condition = [['user_id',$userId]];
        $relations = ['user'];
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $notInId = $this->getWhoBlockMeIds($userId);
        $wherHasTbl = 'user';
        $wherHasCon = [['status',1]];
        $followers = $this->userFollowers->getWithCondition($condition,$limit,$relations,$wherHasTbl,$wherHasCon,$notInId);
        return $followers;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 21/04/2020
    @FunctionFor: Company details by slug
    @param: string $userSlug
    @return : array $details
    */
    public function getDetailsBySlug($userSlug){
        $condition = [['slug',$userSlug]];
        $relations = ['country','state','profile','profileImage','bannerImage','isUserBlockedByLogedInUser'];
        $details = $this->user->showWith($condition,$relations);
        return $details;
    }

     /**
     * Function to get candidate info with email
     * @param string $email
     * @return array $candidateInfo
     */
    public function updateUserStatus($request)
    {
        $id = $request['id'];
        $update = [];
        if($request['acc'] != 3){
            $update['status'] = $request['acc'];
            $candidateInfo = $this->user->update($update,$id);
            if($request['acc'] == 1){
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

            }else if($request['acc'] == 2){
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

        }else if($request['acc'] == 3){
            
            $post = JobPost::where('user_id', $id)->get();
            if(!empty($post)){
                foreach($post as $key=>$val){
                     JobApplied::where('job_id', $val['id'])->delete();
                     UserPostLike::where('post_id', $val['id'])->delete();
                     CommonComment::where('type_id', $val['id'])->delete();
                }
            }
            
            /* JobApplied::where('user_id', $id)->delete();
            UserPostLike::where('user_id', $id)->delete();
            CommonComment::where('user_id', $id)->delete(); */
            JobPost::where('user_id', $id)->delete();
            User::where('id', $id)->update(['status' => 0]);
            $candidateInfo = $this->user->delete($id);
        }
        return $candidateInfo;
        
    }
    /**
     * Function to delete old profile images
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldBannerImg($userId)
    {
        $condition [] = ['type_id','=',$userId];
        $condition [] = ['type','=','banner_img'];
        $this->uploadRepository->deleteWhere($condition);   
    }

    /**
     * Function to upload profile images
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadBannerImage($request)
    {
        $userId = Auth::user()->id;
        //$path = '\upload\company'."\/".$userId;
        $path    = '/upload/company'."/".$userId;
        $pathWeb = '/upload/company'."/".$userId;
        $this->deleteOldBannerImg($userId);
        $directoryStatus = $this->uploadService->createDirecrotory($path);
        $uploadResponse  = $this->uploadService->file_upload($path,'banner_img',$request);
        if($uploadResponse['success']){
            $options["file_name"] = $uploadResponse['file_name'];
            $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
            $options["uploads_type"] = 'image';
            $options["user_id"] = $userId;
            $options["description"] = "Banner image uploaded successfully";
            $options["type_id"] = $userId;
            $options["type"] = 'banner_img';
            $options['org_name'] = $uploadResponse['org_name'];
            $this->uploadService->createUploadsProfile($options);
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
   }


   /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/04/2020
    @FunctionFor: Company details
    @Param: int $userId
    @Return: object Array
    */
    public function getDetails($userId){        
        $condition = [['id',$userId]];
        $relations = ['country','state','city','profile','profileImage','bannerImage'];
        $details = $this->user->showWith($condition,$relations);
        // dd($details);
        return $details;
    }

    /**
     * Function to upload profile images
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadProfileImage($request)
    {
        $userId = Auth::user()->id;
        //$path = '\upload\candidate'."\/".$userId;
        $path    = '/upload/company'."/".$userId;
        $pathWeb = '/upload/company'."/".$userId;
        $this->deleteOldProfileImg($userId);
        $directoryStatus = $this->uploadService->createDirecrotory($path);
        $uploadResponse  = $this->uploadService->file_upload($path,'profil_image',$request);
        if($uploadResponse['success']){
            $options["file_name"] = $uploadResponse['file_name'];
            $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
            $options["uploads_type"] = 'image';
            $options["user_id"] = $userId;
            $options["description"] = "Profile image uploaded successfully";
            $options["type_id"] = $userId;
            $options["type"] = 'profile_img';
            $options['org_name'] = $uploadResponse['org_name'];
            $this->uploadService->createUploadsProfile($options);
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
   }
   /**
     * Function to delete old profile images
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldProfileImg($userId)
    {
        $condition [] = ['type_id','=',$userId];
        $condition [] = ['type','=','profile_img'];
        $this->uploadRepository->deleteWhere($condition);   
    }

    /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function storeProfileInfo($request)
   {      
      $data = $request->all();     
      $userUpdate['first_name'] = base64_encode($data['first_name']);
      $userUpdate['company_name'] = $data['company_name'];
      $userUpdate['telephone'] = base64_encode($data['telephone']);
      $userUpdate['address1'] = $data['address1'];
      $userUpdate['address2'] = $data['address2'];
      $userUpdate['postal'] = $data['postal'];
      $userUpdate['city_id'] = $data['city_id'];
      $userUpdate['state_id'] = $data['state_id'];
      $userUpdate['country_id'] = $data['country_id'];

      $status = $this->user->update($userUpdate,Auth::user()->id);
      $profileData['business_name'] = $data['business_name'];
      $condition[] = ["user_id","=",Auth::user()->id];
      $profileInfo   = $this->profile->findSingleRow($condition);
      $statusProfile = $this->profile->update($profileData,$profileInfo->id);
      
      if($status){
         $response = Response::json('success', 200);
      }else{
         $response = Response::json('error', 400);
      }
      return $response;
   }
   /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function checkUniqueCompany($request){
      $company = $request['company'];
      $userId = Auth::user()->id;
      $condition = [['company_name','=',$company],['user_type','=',3],['id','!=',$userId]];
      $chkCompany = $this->user->getCount($condition);
      return $chkCompany; 
   }

  /**
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function findCandidates($search = '') {
      DB::enableQueryLog();
      //dd($search);
        $userId = Auth::user()->id;
        $blockUserIds = $this->getWhoBlockMeIds($userId);
        $candidate = User::where([['user_type',2],['status',1]])->whereNotIn('id',$blockUserIds)->with('country','state','profile','currentCompany','profileImage','userLanguageFluency','connection','connectionAcceptBy');
        if((isset($search['profile_headline'])) && ($search['profile_headline'] != '')){
            $profileFilters = explode(",",urldecode($search['profile_headline']));
            $condition = $profileFilters;
            //dd($condition);
            $candidate = $candidate->whereHas('profile',function($q) use ($condition) {
                for ($i = 0; $i < count($condition); $i++){
                    if($i == 0){
                        $q->where('profile_headline','like',  '%' . $condition[$i] .'%');
                    }else if($i > 0){
                        $q->orWhere('profile_headline','like',  '%' . $condition[$i] .'%');
                    }
                    
                }
            });
            // $candidate = $candidate->whereHas('profile',function($q) use ($condition) {
            //     for ($i = 0; $i < count($condition); $i++){
            //     $q->orwhere('profile_headline', 'like',  '%' . $condition[$i] .'%');
            //          // ->orwhere('job_id', 'like',  '%' . $whereLikeCond[$i] .'%');
            //     }      
            // });
          }
        if((isset($search['country_id'])) && ($search['country_id'] != '')){
            $candidate = $candidate->where('country_id',$search['country_id']);
        }
        if((isset($search['name'])) && ($search['name'] != '')){
            $candidate = $candidate->where('first_name','LIKE','%'.$search['name'].'%');
        }
        if((isset($search['state'])) && ($search['state'] != '')){
            $profileFiltersState = explode(",",urldecode($search['state']));
            $conditionState = $profileFiltersState;
            $candidate = $candidate->whereIn('state_id', $conditionState);
        }
        if((isset($search['language'])) && ($search['language'] != '')){
            $profileFiltersLang = explode(",",urldecode($search['language']));
            $langArr = $profileFiltersLang;
            $candidate = $candidate->whereHas('userLanguageFluency',function($q) use ($langArr) {
                $q->whereIn('master_cms_cat_id',$langArr);
            });
            
        }
        
        $candidate = $candidate->orderBy("id","DESC");
        //return $candidate;
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $page = $search['page'];
        $skip = $limit * ($page - 1);
        //$candidate = $candidate->skip($skip)->take(2)->toSql();dd($candidate);
        $candidate = $candidate->skip($skip)->take($limit)->get();
    //    dd(DB::getQueryLog());
        return $candidate;
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function getPostList($userId,$search=''){        
        $condition = [['status',1],['user_id',$userId]];
        $relations = ['company','upload','postState','likes','comments','reportedPost'];
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        //$companyPost = $this->jobPost->getWith($condition,$limit,$relations);
        //User::doesntHave('posts')->get();
        $companyPost = jobPost::doesntHave('reportedPost')
                                ->where($condition)
                                ->with($relations)
                                ->orderBy("id","DESC")->paginate($limit);
        
        return $companyPost;
    }
     /**
     * Function to delete post
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function deleteUserPost($request)
    {
        $id = $request['id'];
        $status = $this->chkUserPostStatus($id);
        if($status == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $status = $this->uploadService->deletePostStuff($id);
        $status = $this->jobPost->delete($id);
        $status = $this->userPostShare->deleteByCondition([['post_id',$id]]);
        $status = $this->notification->deleteByCondition([['type_id',$id],['type','=','share_post']]);  
        $status = $this->notification->deleteByCondition([['type_id',$id],['type','=','like']]);   
        $status = $this->notification->deleteByCondition([['type_id',$id],['type','=','comment']]); 
        $status = $this->uploadRepository->deleteByCondition([['type_id',$id]]);  
        $condition = [['type_id',$id]];
        $getallcomm = $this->commonCommentRepository->getAll($condition)->toArray();
        $status = $this->commonCommentRepository->deleteByCondition([['type_id',$id]]);
        if(!empty($getallcomm)){
            foreach($getallcomm as $key=>$val){
                $status = $this->reportedPostRepository->deleteByCondition([['type_id','=',$val['id']],['type','=','post_comment']]);
            }
        }
        $status = $this->reportedPostRepository->deleteByCondition([['type_id',$id],['type','post']]);
        $status = $this->postState->deleteByCondition([['post_id',$id]]);
        $status = $this->jobpostCmsBasicInfo->deleteByCondition([['post_id',$id]]);
        $status = $this->selectedSkill->deleteByCondition([['type','post'],['type_id',$id]]);
        
        if($status){
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
   }
    /**
     * Function to list comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function listUserPostComment($request) {
        $id = $request['id'];
        $userId = Auth::user()->id;
        $blockUserIds = $this->getWhoBlockMeIds($userId);
        $condition = [['status','=',1],['type_id','=',$id],['type','=','post']];
        $relations = ['reported','activeUser'];
        $limit = '';
        $whereNotIn = $blockUserIds;
        $candidatePost = $this->commonCommentRepository->getWith($condition,$limit,$relations,'','','','',$whereNotIn);
        return $candidatePost;
    }
     /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function reportComment($request) {
        $id = $request['comment_id'];
        $condiCommonCmnt[] = ['id','=',$id];
        $relationCommonCmnt = ['user'];
        $commentDetails = $this->commonCommentRepository->showWith($condiCommonCmnt,$relationCommonCmnt);
        $userId = Auth::user()->id;
        $insertData = [];
        $insertData['type'] = 'post_comment';
        $insertData['type_id'] = $id;
        $insertData['comment'] = $request['comment'];
        $insertData['status'] = 0;
        $insertData['user_id'] = $userId;
        $report = $this->reportedPostRepository->create($insertData);
        if($report){
            $notification = [];
            $notification['type'] = 'report';
            $notification['type_id'] = $report->id;
            $notification['from_user_id'] = $userId;
            $notification['to_user_id'] = 1;
            $this->notification->create($notification);
            
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $dataMail['imgPath'] = $imgPath;
            $dataMail['logoPath'] = $logoPath;
            $conditions[] = ['id','=',1];
            $toUser = $this->user->findSingleRow($conditions);
            $dataMail['first_name'] = $toUser['first_name'];
            $dataMail['comment_user_names'] = $commentDetails['user']['first_name'];
            $dataMail['from_first_name'] = Auth::user()->first_name;
            Mail::to($toUser['email'])->send(new CommentReportNotification($dataMail));

            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
        
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $seniority
    */
    public function getSeniorityList(){        
        $condition = [['status','=',1],['type','=','seniority']];
        $seniority = $this->masterCmsCategory->getAllOrder($condition,'id','asc');
        return $seniority;
    }
    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $seniority
    */
    public function getEmploymentList(){        
        $condition = [['status','=',1],['type','=','employment_type']];
        $employment = $this->masterCmsCategory->getAllOrder($condition,'id','asc');
        return $employment;
    }
    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $language
    */
    public function getLanguageList(){        
        $condition = [['status','=',1],['type','=','language']];
        $language = $this->masterCmsCategory->getAllOrder($condition,'name','asc');
        return $language;
    }
    /**
     * Function to post job
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function postJobPost($request) {
       
        $data = $request->all();
        //dd($data);
        $userId = Auth::user()->id;
        $paymentId = base64_decode($data['id']);
        //INSERT POST TBL DATA
        $slug = $this->getUniqueSlug($data['title']);
        $postData = [];
        $postData['title'] = $data['title'];
        $postData['slug'] = $slug;
        $postData['country_id'] = 14;
        $postData['status'] = 1;
        $postData['user_id'] = $userId;
        // $postData['city'] = $data['city'] ?? '-';
        $postData['description'] = $data['description'];
        $postData['start_date'] = $data['start_date'];
        $postData['end_date'] = $data['end_date'];
        $postData['applied_by'] = 2;
        $postData['category_id'] = 1;
        if($paymentId!=0)
        {
            $postData['highlighted'] = 1;
        }

        //CITY
        if(isset($data['city']) && !empty($data['city'])){
            //$city = implode(",",$data['city']);
            $postData['city'] = $data['city'];
        }else{
            $postData['city'] = '-';
        }

        if(isset($data['type']) && !empty($data['type'])){
            //$city = implode(",",$data['city']);
            $postData['type'] = $data['type'];
        }

        
        if(isset($data['applied_by']) && $data['applied_by'] == 2){
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
        $post = $this->jobPost->create($postData);
        //INSERT STATE TBL DATA
        // foreach($data['state_id'] as $key=>$val){
        //     $stateData = [];
        //     $stateData['post_id'] = $post->id;
        //     $stateData['state_id'] = $val;
        //     $state = $this->postState->create($stateData);
        // }
        //INSERT SELECTEDSKILL TBL DATA
        if((isset($data['itskill'])) && $data['itskill'] != null){
        $insertData = [];
          foreach($data['itskill'] as $key=>$val){

            if(is_numeric($val) == false){
                $insertArr = [];
                $insertArr['name'] = ucwords(trim($val));
                $insertArr['status'] = 1;
                $insertId = $this->skill->create($insertArr);
                $insertData['skill_id'] = $insertId->id;
                unset($data['itskill'][$key]);
                array_push($data['itskill'],$insertId->id);
            }else{
                $insertData['skill_id'] = $val;
            }
            $insertData['type'] = 'post';
            $insertData['type_id'] = $post->id;
            $skillInsert = $this->selectedSkill->create($insertData);

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
            $cmsMaster = $this->jobpostCmsBasicInfo->create($cmsBasicInfo);
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
            $cmsMaster = $this->jobpostCmsBasicInfo->create($cmsBasicInfoEmp);
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
                    $cmsMasterLang = $this->masterCmsCategory->create($cmsMasterLang);
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
                $cmsMaster = $this->jobpostCmsBasicInfo->create($cmsBasicInfoLang);
            }
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
        //GET FOLLOWER AND SEND NOTIFICATIONS FOR NEW JOB
        if($postData['job_status'] == 1){
            $cond = [];
            $cond['user_id'] = $userId;
            $relation = 'user';
            $blockUserIds = $this->getWhoBlockMeIds($userId);
            $blockUserByMe = $this->getWhomBlockByMeIds($userId);
            $whereNotIn = array_merge($blockUserIds,$blockUserByMe);
            // $whereNotIn = $this->getWhomBlockByMeIds($userId);
            $followers = $this->userFollowers->getAllUnblockFollower($cond,$relation,$whereNotIn,'');
            
            if(!empty($followers)){
                foreach($followers as $key=>$val){
                    $notification = [];
                    $notification['type'] = 'job';
                    $notification['type_id'] = $post->id;
                    $notification['from_user_id'] = $userId;
                    $notification['to_user_id'] = $val['follower_id'];
                    $this->notification->create($notification);

                    $whereInArr = [];
                    $condition1['status'] = 1;
                    $relations = ['company','country','postState','cmsBasicInfo'];
                    $whereInField = 'id';
                    $whereInArr[0] = $post->id;
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
        }
        return $post;
        
    }
    /**
     * Function to post job questions
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function postQuestionJobPost($data) {
        //SCREENING QUESTIONS
        if(isset($data['screening_1']) && ($data['screening_1'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $data['postId'];
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_1'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_2']) && ($data['screening_2'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] =$data['postId'];
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_2'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        if(isset($data['screening_3']) && ($data['screening_3'] != '')){
            $scriningAdd = [];
            $scriningAdd['post_id'] = $data['postId'];
            $scriningAdd['type'] = 1;
            $scriningAdd['question'] = $data['screening_3'];
            $scrining = $this->jobPostSpecificQuestions->create($scriningAdd);
        }
        //INTERVIEW QUESTIONS
        if(isset($data['interview_1']) && ($data['interview_1'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $data['postId'];
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_1'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_2']) && ($data['interview_2'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $data['postId'];
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_2'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        if(isset($data['interview_3']) && ($data['interview_3'] != '')){
            $interviewAdd = [];
            $interviewAdd['post_id'] = $data['postId'];
            $interviewAdd['type'] = 2;
            $interviewAdd['question'] = $data['interview_3'];
            if(isset($data['mandatory_setting']) && ($data['mandatory_setting'] != '')){
                $interviewAdd['mandatory_setting'] = $data['mandatory_setting'];
            }
            $interview = $this->jobPostSpecificQuestions->create($interviewAdd);
        }
        return 1;
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
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function jobList($request){ 
        $data = $request->all();
        //dd($data);
        $userId = Auth::user()->id; 
        $relations = ['country','postState','selectedSkill','cmsBasicInfo','questions','totalAppliedJob'];    
        $condition = [['status','=',1],['category_id','=',1],['user_id','=',$userId]];
        $condition1 = '';
        $relationTbl = '';
        if(request()->input('title',false) != false){
            $condition [] = ['title','LIKE','%'.$data['title'].'%'];
        }
        if(request()->input('citySearch',false) != false){
            $condition [] = ['city','LIKE','%'.$data['citySearch'].'%'];
        }
        
        if(request()->input('job_id',false) != false){
            $condition [] = ['job_id','=',$data['job_id']];
        }
        if(request()->input('country_id',false) != false){
            $condition [] = ['country_id','=',$data['country_id']];
        } else if(empty($data)){
            $condition [] = ['country_id','=',14]; 
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
                $condition [] = ['job_status','=',1];
            }
            if($data['status'] == 2){
                $condition [] = ['job_status','=',2];
            }
            if($data['status'] == 3){
                $condition [] = ['job_status','=',0];
            }
           
        }else{
            $condition [] = ['job_status','=',1];
        }
        
        if(request()->input('state',false) != false){
            $condition1  = [['state_id','=',$data['state']]];
            $relationTbl = 'postState';
        } 
        
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $jobPost = $this->jobPost->getSearchWithRelationAll($condition,$condition1,$limit,$relations,$relationTbl);
        //dd($jobPost[1]['totalAppliedJob']);
        return $jobPost;
    }
    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function jobDetails($request){ 
        //$userId = Auth::user()->id;
        $jobId = $request['id'];     
        $condition = [['id','=',$jobId]];
        $relations = ['country','postState','selectedSkill','cmsBasicInfo','questions'];
        $jobPost = $this->jobPost->showWith($condition,$relations);
        //dd($jobPost);
        return $jobPost;
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
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function appliedCandidates($search = '') {
       
              $condition['id'] = 0;
              $jobId = $search['id'];
              
              $candidate = JobPost::where([['id','=',$search['id']]])->with(['totalAppliedJob' => function($query) use ($condition) {                  
                    $query->whereHas('user', function ($query) use ($condition) {
                            $userId = Auth::user()->id;
                            $blockUserIds = $this->getWhoBlockMeIds($userId);
                            $query = $query->whereNotIn('id',$blockUserIds);
                           //ACTIVE USER
                           $conditions[] = ['status','=',1];
                            // user id != blank
                          
                           $conditions[] = ['id','!=',$condition['id']];
                           //  //if country search
                            if((request('country_id'))){
                                $conditions[] = ['country_id','=',request('country_id')];
                            }
                           //  //if city

                            if(request('city')){
                                $conditions[] = ['city_id','Like','%'.request('city').'%'];                                
                            }
                            
                            //if state
                            if(request('state_id')){
                                $conditions[] = ['state_id','=',request('state_id')];
                            }
                            $query->where($conditions);
                            // if(request('state')){
                            //    $states = request('state');
                            //    $statesArray = [];
                            //    foreach ($states as $key => $val) {
                            //      # code...
                            //             $statesArray[] = $val;
                            //    }
                            //    //$conditionState[] = ['state_id',$statesArray];
                            //   $query->whereIn('state_id',$statesArray);
                            // }
                            if(request('language')){
                                $query->whereHas('userLanguageFluency', function ($query) use ($condition) {
                                    $language = request('language');
                                    $statesArray = [];
                                    foreach ($language as $key => $val) {
                                        # code...
                                                $languageArray[] = $val;
                                    }
                                    $query->whereIn('master_cms_cat_id',$languageArray);
                                });
                           
                            }  
                            
                        });
                        // $query->whereHas('uploaded_cv', function ($query) {
                        //     $query->where(array('uploads_type' => 'file','type' => 'user_cv'));
                        // });
                       
                       
                    },
                    'totalAppliedJob.uploaded_cv' => function($query) use($jobId){
                        $query->where(array('job_id' => $jobId, 'uploads_type' => 'file','type' => 'user_cv'));
                    },
                    'totalAppliedJob.uploaded_other_doc' => function($query) use($jobId){
                        $query->where(array('job_id' => $jobId, 'uploads_type' => 'file','type' => 'user_other_doc'));
                    }
                ]);
                
             $candidate = $candidate->first();
             //dd($candidate);
             return $candidate;
    }
    public function isReported($id){
        $report = ReportedPost::where([['type_id', $id],['type' , 'company'],['status',0]])->orderBy("id","ASC")->pluck('user_id')->all();
        return $report;
    }

     /**
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function candidateConnectedList($search = '') {
        if(!empty($search['name'])){
            $search = $search['name'];
        }else{
            $search = '';
        }
        $userId = Auth::user()->id;
        $blockUserIds = $this->getWhoBlockMeIds($userId);
        $candidate = UserConnection::where([['request_sent_by',$userId],['status',1]])->whereNotIn('request_sent_by',$blockUserIds)->with('userConnectedWithCompany','user');
        $candidate = $candidate->whereHas('userConnectedWithCompany',function($q) use($search){
            if($search != ''){
                $q->where([['status','=',1],['user_type','=',2],['first_name','Like','%'.$search.'%']]);
            }else{
                $q->where([['status',1],['user_type',2]]);
            }
            
        });
        $candidate = $candidate->whereHas('user',function($q) {
            $q->where('status',1);
        });
        $candidate = $candidate->orderBy("id","DESC")->get()->toArray();
       
        return $candidate;
    }
    /**
     * Funcion to get candidate's connection's ids
     * @param integer $userId
     * @return array $followingIds
     */
    public function getWhoBlockMeIds($userId)
    {
       $myBlockIds = [0];
       $conditions = [['blocked_user_id','=',$userId]];
       $myBlocks = $this->userBlock->getAll($conditions);
       if($myBlocks->isNotEmpty()){
           foreach ($myBlocks as $key => $row) {
                     $myBlockIds[] = $row->blocked_by;
           }
       }
       return $myBlockIds;
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

    public function checkUniqueEmail($data){
        $email = base64_encode($data['email']);
        $condision = [['email','=',$email]];
        $count = $this->user->getCount($condision);
        return $count;
    }

    public function chkUserPostStatus($postId){
        $userId = Auth::user()->id;
        $user = User::where([['id',$userId],['status',1]])->get()->first();
        $post = JobPost::where([['id',$postId],['status',1]])->get()->first();
        if(!empty($user) && !empty($post)){
            return 1;
        }else{
            return 0;
        }
        
    }

    /**
     * Function to delete post
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function deleteUserComment($request)
    {
        $id = $request['id'];
        $condi = [['id',$id]];
        $commentDetails = $this->commonCommentRepository->findSingleRow($condi); 
        $status = $this->commonCommentRepository->delete($id);  
        $status = $this->notification->deleteByCondition([['type_id',$id],['type','comment']]); 
        $status = $this->reportedPostRepository->deleteByCondition([['type_id',$id],['type','post_comment']]);      
        
        if($status){
            $response = $commentDetails['type_id'];
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
    }
    

    public function uploadJobDescImage($request) {
        $fileObject = $request->file('upload');
		$photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand().'_'.time().'.'.$ext;
        $filePath = public_path().'/upload/job_post_description';
        if (! File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $photo->move($filePath.'/', $filename);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
		// $url = asset('/upload/job_post_description/'.$filename);
        $url = env('APP_URL').'upload/job_post_description/'.$filename;
        Log::info($url);
		$msg = 'Image uploaded successfully'; 
		$response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
		   
		@header('Content-type: text/html; charset=utf-8'); 
		echo $response;
    }
    

}