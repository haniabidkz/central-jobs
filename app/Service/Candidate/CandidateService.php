<?php
namespace App\Service\Candidate;
use App\Repository\Candidate\CandidateRepository;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Repository\CommonRepository;
use App\Http\Model\User;
use App\Http\Model\UserFollowers;
use App\Http\Model\Skill;
use App\Service\CountryService;
use App\Service\UploadService;
use App\Http\Model\Upload;
use App\Http\Model\CommonComment;
use App\Http\Model\ReportedPost;
use App\Http\Model\Profile;
use App\Http\Model\CmsBasicInfo;
use App\Http\Model\MasterCmsCategory;
use App\Http\Model\selectedSkill;
use App\Http\Model\UserProfessionalInfo;
use App\Http\Model\UserEducatioalInfo;
use App\Http\Model\JobPost;
use App\Http\Model\JobApplied;
use App\Http\Model\PostState;
use App\Http\Model\UserBlock;
use App\Http\Model\Advertisements;


use Response;
use Auth;
use File;
use DB;
use Carbon\Carbon;
use App\Mail\CommentReportNotification;
use App\Mail\FollowingNotification;
use App\Mail\CompanyReportNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Model\Notification;
use App\Http\Model\UserPostLike;
use App\Http\Model\UserConnection;
use App\Http\Model\CandidateJobApplyInfo;
use App\Http\Model\UserJobAppliedAnswers;
use App\Http\Model\CronJobMaster;
use App\Mail\ReminderDraftJob;
use App\Mail\JobAlertSettingMail;
use App\Http\Model\UserPostShare;
use App\Http\Model\UserJobAlertHistory;
use App\Http\Model\UserInterviewAttempt;
use App\Jobs\JobAlertNotification;
use Illuminate\Support\Facades\Storage;

class CandidateService {
    
    protected $candidateRepo;
    protected $userRepo;
    protected $user;
    protected $userFollowers;
    protected $uploadService;
    protected $upload;
    protected $profile;
    protected $cmsBasicInfo;
    protected $masterCmsCategory;
    protected $skill;
    protected $selectedSkill;
    protected $userProfessionalInfo;
    protected $userEducatioalInfo;
    protected $jobPost;
    protected $commonComment;
    protected $reportedPost;
    protected $jobApplied;
    protected $notification;
    protected $userPostLike;
    protected $postState;
    protected $userConnection;
    protected $candidateJobApplyInfo;
    protected $userJobAppliedAnswers;
    protected $cronJobMaster;
    protected $userBlock;
    protected $userPostShare;
    protected $userJobAlertHistory;
    protected $userInterviewAttempt;


    /**
     * @param CandidateRepository $candidateRepo reference to ambasadorRepo
     * @param UserRepository $userRepo reference to userRepo
     * 
     */
    public function __construct(
        CandidateRepository $candidateRepo,
        UserRepository $userRepo,
        User $user,
        UserFollowers $userFollowers,
        UploadService $uploadService,
        Upload $upload,
        Profile $profile,
        CmsBasicInfo $cmsBasicInfo,
        MasterCmsCategory $masterCmsCategory,
        Skill $skill,
        selectedSkill $selectedSkill,
        UserProfessionalInfo $userProfessionalInfo,
        UserEducatioalInfo $userEducatioalInfo,
        JobPost $jobPost,
        CommonComment $commonComment,
        ReportedPost $reportedPost,
        JobApplied $jobApplied,
        Notification $notification,
        UserPostLike $userPostLike,
        PostState $postState,
        UserConnection $userConnection,
        CandidateJobApplyInfo $candidateJobApplyInfo,
        UserJobAppliedAnswers $userJobAppliedAnswers,
        CronJobMaster $cronJobMaster,
        UserBlock $userBlock,
        UserPostShare $userPostShare,
        UserJobAlertHistory $userJobAlertHistory,
        UserInterviewAttempt $userInterviewAttempt
    ) {
        $this->candidateRepo = $candidateRepo;
        $this->userRepo = $userRepo;
        $this->uploadService = $uploadService;
        $this->uploadServiceCommon = new CommonRepository($upload);
        $this->user = new CommonRepository($user);
        $this->userFollowers = new CommonRepository($userFollowers);
        $this->uploadRepository = new CommonRepository($upload);
        $this->profile = new CommonRepository($profile);
        $this->cmsBasicInfo = new CommonRepository($cmsBasicInfo);
        $this->masterCmsCategory = new CommonRepository($masterCmsCategory);
        $this->skill = new CommonRepository($skill);
        $this->selectedSkill = new CommonRepository($selectedSkill);
        $this->userProfessionalInfo = new CommonRepository($userProfessionalInfo);
        $this->userEducatioalInfo = new CommonRepository($userEducatioalInfo);
        $this->jobPost = new CommonRepository($jobPost);
        $this->commonCommentRepository = new CommonRepository($commonComment);
        $this->reportedPostRepository = new CommonRepository($reportedPost);
        $this->jobApplied = new CommonRepository($jobApplied);
        $this->notification = new CommonRepository($notification);
        $this->userPostLike = new CommonRepository($userPostLike);
        $this->postState = new CommonRepository($postState);
        $this->userConnection = new CommonRepository($userConnection);
        $this->candidateJobApplyInfo = new CommonRepository($candidateJobApplyInfo);
        $this->userJobAppliedAnswers = new CommonRepository($userJobAppliedAnswers);
        $this->cronJobMaster = new CommonRepository($cronJobMaster);
        $this->userBlock = new CommonRepository($userBlock);
        $this->userPostShare = new CommonRepository($userPostShare);
        $this->userJobAlertHistory = new CommonRepository($userJobAlertHistory);
        $this->userInterviewAttempt = new CommonRepository($userInterviewAttempt);
    }

    /** 
     * Get All Candidate List
    */
    public function fetchList($search='') {
        return $this->candidateRepo->get($search);
    }
     /** 
     * Get Candidate details
    */
    public function details($id=''){
        return $this->candidateRepo->findOne($id);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/04/2020
    @FunctionFor: Candidate details
    */
    public function getDetails($userId){        
        $condition = [['id',$userId]];
        $relations = ['country','state','city','profile','profileImage','bannerImage','cmsBasicInfo','uploadedCV','userSkill','professionalInfo','introVideo','educationalInfo'];
        $details = $this->user->showWith($condition,$relations);
        // dd($details);
        return $details;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 21/04/2020
    @FunctionFor: Candidate details by slug
    */
    public function getDetailsBySlug($userSlug){
        $condition [] = ['slug','=',$userSlug];
        $userInfo = $this->user->findSingleRow($condition);
        $conditionUser = [['id',$userInfo['id']]];
        $relations = ['country','state','profile','bannerImage','profileImage','uploadedCV','selectedSkill','cmsBasicInfo','professionalInfo','educationalInfo','connection','connectionAcceptBy','isUserBlockedByLogedInUser'];
        $conditionWith = [['type','=','candidate']];
        $relationTbl = 'selectedSkill';
        $details = $this->user->getDetailWithOthers($conditionUser,$conditionWith,$relations,$relationTbl);
        return $details;
    }
     /**
     * Function to get all slug from table
     * @param string $slugString
     * @return array $allSlug
     */
    public function getAllSlug($slugString='') 
    {        
        $condition [] = ['slug','LIKE',$slugString.'%'];
        return $this->user->getAll($condition);
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
     * Function to get candidate info with email
     * @param string $email
     * @return array $candidateInfo
     */
    public function getCandInfo($email)
    {
        $condition [] = ['email','=',$email];
        $candidateInfo = $this->user->findSingleRow($condition);
        return $candidateInfo;
    }
    /**
     * Get post list
     * @return post
     */
    public function getSkillList() {
        $skill = Skill::where([['status','=','1']])->orderBy("id","ASC")->pluck('name', 'id')->all();
        return $skill;
    }
     /**
     * Get post list
     * @return post
     */
    public function getSkillArr() {
        $skill = Skill::where([['status','=','1']])->orderBy("name","ASC")->get()->toArray();
        return $skill;
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
     * Function to upload profile images
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadProfileImage($request)
    {
        $userId = Auth::user()->id;
        //$path = '\upload\candidate'."\/".$userId;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
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
            
            JobApplied::where('user_id', $id)->delete();
            UserPostLike::where('user_id', $id)->delete();
            CommonComment::where('user_id', $id)->delete();
            JobPost::where('user_id', $id)->delete();
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
     * Function to delete old CV
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldCv($userId, $jobId = NULL)
    {
        $condition [] = ['type_id','=',$userId];
        if($jobId != NULL)
        {
            $condition [] = ['job_id', '=', $jobId];
        }
        $condition [] = ['type','=','user_cv'];
        $uploadInfo = $this->uploadRepository->findSingleRow($condition);
        if($uploadInfo){             
            if(file_exists(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name)){
              unlink(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name);
            }
            $this->uploadRepository->deleteWhere($condition);
        }
    }
    /**
     * Function to delete old doc
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldDoc($userId, $request)
    {
        if(isset($request->additional_doc_id))
        {
            foreach($request->additional_doc_id as $doc_id){
                $condition [] = ['id', '!=', $doc_id];
            }
        }
        $condition [] = ['type_id','=',$userId];
        $condition [] = ['type','=','user_other_doc'];
        $uploadInfos = $this->uploadRepository->getAll($condition);
        foreach($uploadInfos as $uploadInfo)
        if($uploadInfo){
            if(file_exists(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name)){
              unlink(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name);
            }
            $this->uploadRepository->deleteWhere($condition);
        }
    }
    /**
     * Function to delete old CV
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldIntroVideo($userId)
    {
        $condition [] = ['type_id','=',$userId];
        $condition [] = ['type','=','user_video_intro'];
        $uploadInfo = $this->uploadRepository->findSingleRow($condition);
        if($uploadInfo){             
            if(file_exists(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name)){
              unlink(public_path().'/upload/candidate/'.$userId.'/'.$uploadInfo->name);
            }
            $this->uploadRepository->deleteWhere($condition);
        }
    }
    /**
     * Function to upload profile images
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadBannerImage($request)
    {
        $userId = Auth::user()->id;
       // $path = '\upload\candidate'."\/".$userId;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
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
   /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function storeProfileInfo($request)
   {      
      $data = $request->all();     
      $userUpdate['first_name'] = base64_encode($data['first_name']);
    //   $userUpdate['address1'] = $data['address1'];
    //   $userUpdate['address2'] = $data['address2'];
    //   $userUpdate['postal'] = $data['postal'];
      $userUpdate['city_id'] = $data['city_id'];
      $userUpdate['state_id'] = $data['state_id'];
      $userUpdate['country_id'] = $data['country_id'];

      $status = $this->user->update($userUpdate,Auth::user()->id);
      $profileData['profile_headline'] = $data['profile_headline'];
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
   public function storeHobbies($request)
   {      
      $data = $request->all(); 
      $dataArr = explode(",",$data['hobby']);
      if(!empty($dataArr)){
        $addUserInfo = [];
        $userId = Auth::user()->id;
        $conditionInfo = [['user_id','=',$userId],['type','=','general_info']];
        $chkHobbyInfo = $this->cmsBasicInfo->findSingleRow($conditionInfo);
        if($chkHobbyInfo){
          $chkHobbyInfo = $this->cmsBasicInfo->deleteByCondition($conditionInfo);
        }
        foreach($dataArr as $key=>$val){
          $condistion = [['name', '=', ucwords(trim($val))],['type', '=', 'hobbies']];
          $chkHobby = $this->masterCmsCategory->findSingleRow($condistion);
          if(empty($chkHobby)){
                $updateMaster = [];
                $updateMaster['name'] = ucwords(trim($val));
                $updateMaster['type'] = 'hobbies';
                $chkHobbyInfo = $this->masterCmsCategory->create($updateMaster);
                $masterId = $chkHobbyInfo->id;
          }else{
                $masterId = $chkHobby->id;
          }
          $condistionBesic = [['user_id','=',$userId],['master_cms_cat_id','=',$masterId],['type','=','general_info']];
          $chkUserHobby = $this->cmsBasicInfo->findSingleRow($condistionBesic);
          $chkHobbyInsert = '';
          if(empty($chkUserHobby)){
              $addUserInfo['user_id'] = $userId;
              $addUserInfo['master_cms_cat_id'] = $masterId;
              $addUserInfo['type'] = 'general_info';
              $chkHobbyInsert = $this->cmsBasicInfo->create($addUserInfo);
          }

          if($chkHobbyInsert){
             $response = Response::json('success', 200);
          }else{
             $response = Response::json('error', 400);
          }
        }
      }
      return $response;
   }

   /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function storeCvSummary($request)
   {      
      $data = $request->all(); 
      $userId = Auth::user()->id;    
      $addUserInfo = [];
      $user = $this->profile->findOne([['user_id','=',$userId]]);
      $addUserInfo['cv_summary'] = $data['cv_summary'];
      $insert = $this->profile->update($addUserInfo,$user['id']);
      if($insert){
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
   public function storeHighlightSentence($request)
   {      
      $data = $request->all(); 
      $userId = Auth::user()->id;    
      $addUserInfo = [];
      $user = $this->profile->findOne([['user_id','=',$userId]]);
      $addUserInfo['highlight_sentence'] = $data['highlight_sentence'];
      $insert = $this->profile->update($addUserInfo,$user['id']);
      if($insert){
         $response = Response::json('success', 200);
      }else{
         $response = Response::json('error', 400);
      }
      return $response;
   }
   /**
    * Function to store CV
    * @param Illuminate\Http\Request $request
    * @return json $response 
    */
   public function storeCv($request)
   {
         $userId = Auth::user()->id;
       // $path = '\upload\candidate'."\/".$userId;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
        $this->deleteOldCv($userId);
        $directoryStatus = $this->uploadService->createDirecrotory($path);
        $uploadResponse  = $this->uploadService->file_upload($path,'user_cv',$request);
        if($uploadResponse['success']){
            $options["file_name"] = $uploadResponse['file_name'];
            $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
            $options["uploads_type"] = 'file';
            $options["user_id"] = $userId;
            $options["description"] = "CV uploaded successfully";
            $options["type_id"] = $userId;
            $options["type"] = 'user_cv';
            $options["org_name"] = $uploadResponse['org_name'];
            $this->uploadService->createUploadsProfile($options);
            $response = $options;
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
   public function storeSkills($request)
   {      
        $data = $request->all(); 
        $userId = Auth::user()->id;
        $conditionInfo = [['type_id','=',$userId],['type','=','candidate']];
        $chkHobbyInfo = $this->selectedSkill->findSingleRow($conditionInfo);
        if($chkHobbyInfo){
          $chkHobbyInfo = $this->selectedSkill->deleteByCondition($conditionInfo);
        }
        $insertData = [];
        if(!empty($data['skill'])){
          foreach($data['skill'] as $key=>$val){

            if(is_numeric($val) == false){
                $insertArr = [];
                $insertArr['name'] = ucwords(trim($val));
                $insertArr['status'] = 1;
                $insertId = $this->skill->create($insertArr);
                $insertData['skill_id'] = $insertId->id;
                unset($data['skill'][$key]);
                array_push($data['skill'],$insertId->id);
            }else{
                $insertData['skill_id'] = $val;
            }
            $insertData['type'] = 'candidate';
            $insertData['type_id'] = $userId;
            $skillInsert = $this->selectedSkill->create($insertData);

          }
        }
        if($skillInsert){

           $skillNames = $this->getSkillName($data['skill']);
           $response = $skillNames;
           //$response = Response::json('success', 200);
        }else{
           $response = Response::json('error', 400);
        }
        
      return $response;
   }
   /**
     * Get post list
     * @return post
     */
    public function getSkillName($conditions) {
        $skill = Skill::whereIn('id',$conditions)->orderBy("name","ASC")->get();
        return $skill;
    }
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function getProfessionalInfo($request){
        $id = $request['id'];
        $infoData = $this->userProfessionalInfo->show($id);
        return $infoData;
    }
    
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function storeProfessionalInfo($request){
        $updateData = '';
        $insertData = '';
        $data = $request->all();
        $company = $data['company_name'];
        $chkCondition = [];
        if(isset($data['id']) && $data['id'] != ''){
            $chkCondition = [['id','!=',$data['id']],['user_id','=',Auth::user()->id],['company_name','=',$company]];
        }else{
            $chkCondition['user_id'] = Auth::user()->id;
            $chkCondition['company_name'] = $company;
        }
        $chk = $this->userProfessionalInfo->getCount($chkCondition);
        if($chk > 0){
            return 0;
        }else{
            $data['user_id'] = Auth::user()->id;
            if(isset($data['currently_working_here']) && $data['currently_working_here'] == 1){
              $data['currently_working_here'] = 1;
              $data['end_date'] = NULL;
            }else{
              $data['currently_working_here'] = 0;
            }
            if(isset($data['id']) && $data['id'] != ''){
              $id = $data['id'];
              unset($data['id']);
              $updateData = $this->userProfessionalInfo->update($data,$id);
            }else{
              $insertData = $this->userProfessionalInfo->create($data);
            }
            if($updateData){
               $response = Response::json('success', 200);
            }else if($insertData){
              $response = $insertData->id;
            }
            else{
               $response = Response::json('error', 400);
            }
            return $response;
        }
        
    }
    /**
     * Function to remove cv from sever
     * @return void
     */
    public function deleteCv()
    {
       $this->deleteOldCv(Auth::user()->id);
    }
    /**
     * Function to store intro video
     * @param Illuminate\Http\Request $request
     * @return json Response 
     */
    public function storeIntroVideo($request)
    {
        $userId = Auth::user()->id;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
        $this->deleteOldIntroVideo($userId);
        $directoryStatus = $this->uploadService->createDirecrotory($path);
        $uploadResponse  = $this->uploadService->intro_video_upload($path,'user_video_intro',$request);
        if($uploadResponse['success']){
            $options["file_name"] = $uploadResponse['file_name'];
            $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
            $options["uploads_type"] = 'file';
            $options["user_id"] = $userId;
            $options["description"] = "Intro video uploaded successfully";
            $options["type_id"] = $userId;
            $options["type"] = 'user_video_intro';
            $options["org_name"] = $uploadResponse['org_name'];
            $this->uploadService->createUploadsProfile($options);
            $response = $options;
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
    }
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function getEducationalInfo($request){
        $id = $request['id'];
        $infoData = $this->userEducatioalInfo->show($id);
        return $infoData;
    }
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function storeEducationalInfo($request){
        $updateData = '';
        $insertData = '';
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if(isset($data['id']) && $data['id'] != ''){
          $id = $data['id'];
          unset($data['id']);
          $updateData = $this->userEducatioalInfo->update($data,$id);
        }else{
          $insertData = $this->userEducatioalInfo->create($data);
        }
        if($updateData){
           $response = Response::json('success', 200);
        }else if($insertData){
           $response = $insertData->id;
        }
        else{
           $response = Response::json('error', 400);
        }
        return $response;
    }
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function getLanguageArr(){
      $infoData = $this->masterCmsCategory->getAll([['type','=','language'],['status','=',1]]);
      return $infoData;
    }
    /**
    * Function to get professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function getProficiencyArr(){
      $infoData = $this->masterCmsCategory->getAll([['type','=','proficiency'],['status','=',1]]);
      return $infoData;
    }

    /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function storeLanguageInfo($request)
   {      

      $data = $request->all(); 
      //return $data;
      $userId = Auth::user()->id;
      //For EDIT
      if(isset($data['old_fluency_id']) && $data['old_fluency_id']!='' && isset($data['old_lang_id']) && $data['old_lang_id']!=''){

        //DELETE PREVIOUS LANGUAGE
        $deleteCondition1 = [['user_id','=',$userId],['type','=','language_info'],['master_cms_cat_id','=',$data['old_lang_id']]];
        $deleteLang = $this->cmsBasicInfo->deleteByCondition($deleteCondition1);
        
        //DELETE PREVIOUS FLUENCY
        $deleteCondition2 = [['user_id','=',$userId],['type','=','proficiency_info'],['master_cms_cat_id','=',$data['old_fluency_id']],['fluency_lang_id','=',$data['old_lang_id']]];
        $deleteFluncy = $this->cmsBasicInfo->deleteByCondition($deleteCondition2);

      }else{
        //For ADD
        $conditionInfo = [['user_id','=',$userId],['type','!=','general_info'],['master_cms_cat_id','=',$data['master_cms_cat_id']]];
        $chklanguageInfo = $this->cmsBasicInfo->findSingleRow($conditionInfo);
        if($chklanguageInfo){
            return 1;
        }
      }
      
        //Insert Language 
        $addUserInfo['user_id'] = $userId;
        $addUserInfo['master_cms_cat_id'] = $data['master_cms_cat_id'];
        $addUserInfo['type'] = 'language_info';
        $chkLangInsert = $this->cmsBasicInfo->create($addUserInfo);
        //Insert Proficiency
        $addProInfo['user_id'] = $userId;
        $addProInfo['master_cms_cat_id'] = $data['master_fluncy'];
        $addProInfo['fluency_lang_id'] = $data['master_cms_cat_id'];
        $addProInfo['type'] = 'proficiency_info';
        $chkPrfInsert = $this->cmsBasicInfo->create($addProInfo);
        if($chkLangInsert){
           $returnData = $this->masterCmsCategory->getAllIdInArray([$data['master_cms_cat_id'],$data['master_fluncy']]);
           $response = $returnData;
        }else{
           $response = Response::json('error', 400);
        }
        return $response;
      
   }

   /**
    * Function to delete intro video
    * @return void
    */
   public function removeIntroVideo()
   {             
      $this->deleteOldIntroVideo(Auth::user()->id);    
   }

   /**
    * Function to store profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function deleteLanguageInfo($request)
   {      

        $data = $request->all(); 
        $userId = Auth::user()->id;
        //DELETE PREVIOUS LANGUAGE
        $deleteCondition1 = [['user_id','=',$userId],['type','=','language_info'],['master_cms_cat_id','=',$data['lang_id']]];
        $deleteLang = $this->cmsBasicInfo->deleteByCondition($deleteCondition1);
        
        //DELETE PREVIOUS FLUENCY
        $deleteCondition2 = [['user_id','=',$userId],['type','=','proficiency_info'],['master_cms_cat_id','=',$data['prof_id']],['fluency_lang_id','=',$data['lang_id']]];
        $deleteFluncy = $this->cmsBasicInfo->deleteByCondition($deleteCondition2);
        
        if($deleteFluncy){
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
      
   }

   /**
    * Function to get myhr uploaded library
    * @return array $imageLibrary
    */
   public function getMyhrImageLibrary()
   {
       $condition [] = ['type','=','image_library'];
       $data = $this->uploadRepository->getAll($condition);         
       return $data->toArray();    
   }

   /**
    * Function to remove professional info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function deleteProfessionalInfo($request)
   {      

        $data = $request->all(); 
        $deleteData = $this->userProfessionalInfo->delete($data['id']);
        return $deleteData;
        
        if($deleteData){
            $response = Response::json('success', 200);
        }else{
           $response = Response::json('error', 400);
        }
        return $response;
      
   }

   /**
    * Function to remove educational info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function deleteEducationalInfo($request)
   {      

        $data = $request->all(); 
        $deleteData = $this->userEducatioalInfo->delete($data['id']);
        return $deleteData;
        
        if($deleteData){
            $response = Response::json('success', 200);
        }else{
           $response = Response::json('error', 400);
        }
        return $response;
   }
  /**
   * Function to copy library banner to profile banner
   * 
   */
  public function uploadBannerImageFromLibrary($request)
  {
  		$data = $request->all();
  		$userId = Auth::user()->id;
  		$condition [] = ['id','=',$data['id']];
        $libraryInfo = $this->uploadRepository->findSingleRow($condition);        
        if($libraryInfo){
        	
        	$options["file_name"] = $libraryInfo->name;
            $options["location"]  =  $libraryInfo->location;
            $options["uploads_type"] = 'image';
            $options["user_id"] = $userId;
            $options["description"] = "Banner image uploaded successfully";
            $options["type_id"]  = $userId;
            $options["type"] 	 = 'banner_img';
            $options["org_name"] = $libraryInfo->org_name;
           
            $conditionD [] = ['type_id','=',$userId];
            $conditionD [] = ['type','=','banner_img'];
            $this->uploadRepository->deleteWhere($conditionD);
            $this->uploadService->createUploadsProfile($options);
        	$response = Response::json('success', 200);
        }else{
        	$response = Response::json('error', 400);
        }

  }

  /**
   * Function to candidate create post
   * 
   */
  public function createPost($request){
    $data = $request->all();
    $userId = Auth::user()->id;
    $postInsertArr = [];
    $postInsertArr['user_id'] = $userId;
    $postInsertArr['description'] = $data['description'];
    $postInsertArr['category_id'] = 2;
    $postInsertArr['status'] = 1;
    $postData = $this->jobPost->create($postInsertArr);
    if((isset($data['image'])) && ($data['image'] != '')){
        //image upload
        if($file   =   $request->file('image')) {
            $path    = '/upload/candidate'."/".$userId;
            $directoryStatus = $this->uploadService->createDirecrotory($path);
            $file = $request->file('image');    
            $org_name = $file->getClientOriginalName();   
            $extension = $file->getClientOriginalExtension();       
            $filename  = 'post_img_'.time().".{$extension}";
            $upload_success = $file->storeAs($path,$filename);
            if($upload_success){
                $options["file_name"] = $filename;
                $options["location"] =  $path.'/'.$filename;
                $options["uploads_type"] = 'image';
                $options["user_id"] = $userId;
                $options["description"] = "Post image uploaded successfully";
                $options["type_id"] = $postData->id;
                $options["type"] = 'post';
                $options['org_name'] = $org_name;
                $this->uploadService->createUploadsProfile($options);
            }
        }
    }
    if((isset($data['video'])) && ($data['video'] != '')){
        $path    = '/upload/candidate'."/".$userId;
        $directoryStatus = $this->uploadService->createDirecrotory($path);
        $file = $request->file('file');  
        $extension = "mp4";       
        $filename  = 'post_video_'.time().".{$extension}";
        $org_name  =  $filename;
        $upload_success = $file->storeAs($path,$filename);
        if($upload_success){
            $options["file_name"] = $filename;
            $options["location"] =  $path.'/'.$filename;
            $options["uploads_type"] = 'video';
            $options["user_id"] = $userId;
            $options["description"] = "Post video uploaded successfully";
            $options["type_id"] = $postData->id;
            $options["type"] = 'post';
            $options["org_name"] = $org_name;
            $this->uploadService->createUploadsProfile($options);
            $response = $options;
        }
    }
    return $postData;
  }

  /**
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function findCandidates($search = '') {
        //DB::enableQueryLog();
     //dd($search);
        $userId = Auth::user()->id;
        $blockUserIds = $this->getMyBlockIds($userId);
        $candidate = User::where([['id','!=',$userId],['user_type',2],['status',1]])->whereNotIn('id',$blockUserIds)->with('country','state','profile','currentCompany','profileImage','connection','connectionAcceptBy');
        if((isset($search['profile_headline'])) && ($search['profile_headline'] != '')){
            $profileFilters = explode(",",urldecode($search['profile_headline']));
            //dd($profileFilters);
            $condition = $profileFilters;
            // $candidate = $candidate->whereHas('profile',function($q) use ($condition) {
            //     $q->whereIn('profile_headline',$condition);
            // });
            $candidate = $candidate->whereHas('profile',function($q) use ($condition) {
                for ($i = 0; $i < count($condition); $i++){
                    if($i == 0){
                        $q->where('profile_headline','like',  '%' . $condition[$i] .'%');
                    }else if($i > 0){
                        $q->orWhere('profile_headline','like',  '%' . $condition[$i] .'%');
                    }
                    
                }
            });
        }
        if((isset($search['candidate_name'])) && ($search['candidate_name'] != '')){
            $candidate = $candidate->where('first_name','LIKE','%'.$search['candidate_name'].'%');
        }
        if((isset($search['country_id'])) && ($search['country_id'] != '')){
            $candidate = $candidate->where('country_id',$search['country_id']);
        }
        if((isset($search['state'])) && ($search['state'] != '')){
            $profileFiltersState = explode(",",urldecode($search['state']));
            $conditionState = $profileFiltersState;
            $candidate = $candidate->whereIn('state_id', $conditionState);
        }
        if((isset($search['current_company'])) && ($search['current_company'] != '')){
            $profileFiltersLang = explode(",",urldecode($search['current_company']));
            $currentCompArr = $profileFiltersLang;
            $candidate = $candidate->whereHas('currentCompany',function($q) use ($currentCompArr) {
                $q->where('currently_working_here',1)
                ->whereIn('company_name',$currentCompArr);
            });
            
        }
        
        $candidate = $candidate->orderBy("id","DESC");
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $page = $search['page'];
        $skip = $limit * ($page - 1);
        $candidate = $candidate->skip($skip)->take($limit)->get();
        return $candidate;
      }
       /**
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function findCompany($search = '') {
        $userId = Auth::user()->id;
        $blockUserIds = $this->getMyBlockIds($userId);
        $candidate = User::where([['user_type',3],['status',1]])->whereNotIn('id',$blockUserIds)->with('country','state','profile','profileImage','followers');
        $candidate = $candidate->whereHas('profile',function($q) {
            $q->where('approve_status',1);
        });
        if((isset($search['company_name'])) && ($search['company_name'] != '')){
            $candidate = $candidate->where('company_name','LIKE','%'.$search['company_name'].'%');
        }
        $candidate = $candidate->orderBy("id","DESC");
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $page = $search['page_company'];
        $skip = $limit * ($page - 1);
        $candidate = $candidate->skip($skip)->take($limit)->get();
        return $candidate;
    }

      /**
     * Get post list
     * @return post
     */
    public function getProfileHeadLines() {
        $profileHeadLine = Profile::whereNotNull('profile_headline')->orderBy("id","ASC")->pluck('profile_headline', 'id')->all();
        $collection = collect($profileHeadLine);

        $unique_data = $collection->unique()->values()->all(); 
        return $unique_data;
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $candidatePost
    */
    public function getPostList($userId){        
        
       // $followingIds = $this->getMyFollowersIds($userId);
        //if company wants to list it's  following post
        $followingIds = $this->getAllCopanyIds();       
        $connectionsIds = $this->getMyConnectionsIds($userId);
        $connectionsAcceptIds = $this->getMyConnectionsAcceptIds($userId);
        $blockUserToMeIds = $this->getMyBlockIds($userId);
        $blockUserByMeIds = $this->getBlockByMeIds($userId);
        $followingIds[]= $userId;
        $followingIds[]= 1;//admin id
        $followingIds = array_merge($connectionsIds,$followingIds);
        $followingIds = array_merge($connectionsAcceptIds,$followingIds);
        $condition = [['status','=',1],['category_id','!=',1]];
        $whereOrCondi = [['status','=',1],['category_id','=',1],['job_status','=',1]];
        $whereIn = $followingIds;// the users id whome post candidate can see
        $blockUserIds = array_merge($blockUserByMeIds,$blockUserToMeIds);
        $whereNotIn = $blockUserIds;// the users id whome post candidate can not see
        $relations = ['postState','user','upload','likes','comments','cmsBasicInfo','reportedPost','sharedPost'];
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $candidatePost = $this->jobPost->getPostWithAllDashboard($condition,$limit,$relations,$whereIn,$whereNotIn,$whereOrCondi);
        //$candidatePost = $this->jobPost->getSearchWithRelationAll($condition,$condition1,$limit,$relations,$relationalTbl);
        //dd($candidatePost);
        return $candidatePost;
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
        $status = $this->uploadRepository->deleteByCondition([['type_id',$id],['type','=','post']]);
        $condition = [['type_id',$id]];
        $getallcomm = $this->commonCommentRepository->getAll($condition)->toArray();
        $status = $this->commonCommentRepository->deleteByCondition([['type_id',$id]]);
        if(!empty($getallcomm)){
            foreach($getallcomm as $key=>$val){
                $status = $this->reportedPostRepository->deleteByCondition([['type_id','=',$val['id']],['type','=','post_comment']]);
            }
        }  
        $status = $this->reportedPostRepository->deleteByCondition([['type_id',$id],['type','post']]);
        
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
        $blockUserIds = $this->getMyBlockIds($userId);
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
     * Function to check job applied or not
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function chkJobApply($candidateSlug){
        $condition [] = ['slug','=',$candidateSlug];
        $userInfo = $this->user->findSingleRow($condition);
        $candidateId = $userInfo['id'];
        $companyId = Auth::user()->id;
        $jobIds = JobPost::where([['status','=','1'],['user_id','=',$companyId],['category_id','=',1]])->orderBy("id","ASC")->pluck('id')->all();
        $apply = $this->jobApplied->getAllIdInArrayData($jobIds);
        if(!empty($apply->count())){
            return 1;
        }else{
            return 0;
        }
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCompanyListArray() {
        $company = UserProfessionalInfo::whereNotNull('company_name')->where(['status'=>1])->orderBy("id","ASC")->pluck('company_name', 'id')->all();
        $collection = collect($company);

        $unique_data = $collection->unique()->values()->all(); 
        return $unique_data;
        
    }
    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function followUnfollowUser($request) {
        $followingId = $request['user_id'];
        $followerId = Auth::user()->id;
        //CHECK USER STATUS
        $chkUserStatus = $this->chkUserStatus($followingId);
        if($chkUserStatus == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $tag = $request['tag'];
        $condition['user_id'] = $followingId;
        $condition['follower_id'] = $followerId;
        $isdata = $this->userFollowers->findSingleRow($condition);
        if((!empty($isdata)) && ($tag == 0)){
            $like = $this->userFollowers->delete($isdata['id']);
        }else if((empty($isdata)) && ($tag == 1)){
            $insertData = [];
            $insertData['follower_id'] = $followerId;
            $insertData['user_id'] = $followingId;
            $follow = $this->userFollowers->create($insertData);
            $followingUserData = $this->user->findSingleRow(['id' => $followingId]);
            if(($followingUserData['user_type'] == 2) && ($tag == 1)){
                $notification = [];
                $notification['type'] = 'follow';
                $notification['type_id'] = $follow->id;
                $notification['from_user_id'] = $followerId;
                $notification['to_user_id'] = $followingId;
                $this->notification->create($notification);
                
                $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
                $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
                $dataMail['imgPath'] = $imgPath;
                $dataMail['logoPath'] = $logoPath;
                $dataMail['first_name'] = $followingUserData['first_name'];
                $dataMail['from_first_name'] = Auth::user()->first_name;
                Mail::to($followingUserData['email'])->send(new FollowingNotification($dataMail));
            }
        }
        $condition = [['user_id',$followingId]];
        $relations = ['user'];
        $notInId = $this->getWhoBlockMeIds($followingId);
        $wherHasTbl = 'user';
        $wherHasCon = [['status',1]];
        $followers = $this->userFollowers->getWithCondition($condition,'',$relations,$wherHasTbl,$wherHasCon,$notInId);
        
        $total = $followers->count();
        return $total;
        
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
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function candidateFollowingList($search = '',$type = '') {
        $userId = Auth::user()->id;
        $blockUserIds = $this->getMyBlockIds($userId);
        $candidate = userFollowers::where('follower_id',$userId)->whereNotIn('follower_id',$blockUserIds)->with('followingUser','user');
        $candidate = $candidate->whereHas('followingUser',function($q) use ($type){
            $q->where([['status',1],['user_type',$type]]);
        });
        $candidate = $candidate->orderBy("id","DESC");
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $page = $search['page'];
        $skip = $limit * ($page - 1);
        $candidate = $candidate->skip($skip)->take($limit)->get();
        return $candidate;
    }
     /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function reportCompany($request) {
        $id = $request['company_id'];
        //CHECK USER STATUS
        $chkUserStatus = $this->chkUserStatus($id);
        if($chkUserStatus == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $relationCommonCmnt = ['user'];
        $companyDetails = $this->user->findSingleRow(['id'=> $id]);
        $userId = Auth::user()->id;
        $insertData = [];
        $insertData['type'] = 'company';
        $insertData['type_id'] = $id;
        $insertData['comment'] = $request['comment'];
        $insertData['status'] = 0;
        $insertData['user_id'] = $userId;
        $report = $this->reportedPostRepository->create($insertData);
        if($report){
            $notification = [];
            $notification['type'] = 'report_company';
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
            $dataMail['comment_user_names'] = $companyDetails['company_name'];
            $dataMail['from_first_name'] = Auth::user()->first_name;
            Mail::to($toUser['email'])->send(new CompanyReportNotification($dataMail));
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
        
    }


     /**
    * Function to search candidate
    * @param Illuminate\Http\Request $request
    * @return array obj $candidate
    */
    public function candidateNetworkList() {
        $userId = Auth::user()->id;
        $blockUserIds = $this->getMyBlockIds($userId);
        $candidate = UserConnection::where([['request_accepted_by',$userId],['status',0]])->whereNotIn('request_accepted_by',$blockUserIds)->with('user');
        $candidate = $candidate->whereHas('user',function($q){
            $q->where('status',1);
        });
        $candidate = $candidate->orderBy("id","DESC")->get()->toArray();
        // $page = $search['page'];
        // $skip = 8 * ($page - 1);
        // $candidate = $candidate->skip($skip)->take(8)->get();
        return $candidate;
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
        $blockUserIds = $this->getMyBlockIds($userId);
        $candidate = UserConnection::where([['request_accepted_by',$userId],['status',1]])->whereNotIn('request_accepted_by',$blockUserIds)->with('user');
        $candidate = $candidate->whereHas('user',function($q) use($search){
            if($search != ''){
                $q->where([['status','=',1],['first_name','Like','%'.$search.'%']])->orWhere([['status','=',1],['company_name','Like','%'.$search.'%']]);
            }else{
                $q->where([['status',1]]);
            }
            
        });
        $candidate = $candidate->orderBy("id","DESC")->get()->toArray();
        

        $candidate1 = UserConnection::where([['request_sent_by',$userId],['status',1]])->whereNotIn('request_accepted_by',$blockUserIds)->with('user1');
        $candidate1 = $candidate1->whereHas('user1',function($q) use($search){
            if($search != ''){
                $q->where([['status','=',1],['first_name','Like','%'.$search.'%']])->orWhere([['status','=',1],['company_name','Like','%'.$search.'%']]);
            }else{
                $q->where([['status',1]]);
            }
            
        });
        $candidate1 = $candidate1->orderBy("id","DESC")->get()->toArray();
        foreach($candidate1 as $key => $val){
            $candidate1[$key]['user'] = $val['user1'];
            unset($candidate1[$key]['user1']);
        }
        $candidate = array_merge($candidate,$candidate1);
        return $candidate;
    }
     /**
    * Function to get all position
    * @param Illuminate\Http\Request $request
    * @return array obj $position
    */
    public function positionFor(){
        $positionFor = JobPost::whereNotNull('title')->where([['category_id',1],['status',1]])->pluck('title', 'id')->all();
        $collection = collect($positionFor);

        $unique_data = $collection->unique()->values()->all(); 
        return $unique_data;
    }

     /**
    * Function to get all company name
    * @param Illuminate\Http\Request $request
    * @return array obj $position
    */
    public function companyName(){
        $company = User::whereNotNull('company_name')->where(['status'=>1])->orderBy("company_name","ASC")->pluck('company_name', 'id')->all();
        $collection = collect($company);

        $unique_data = $collection->unique()->values()->all(); 
        return $unique_data;
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function jobList($request){ 
        $data = $request->all();
        //dd($data);
        $relations = ['company','country','postState','selectedSkill','cmsBasicInfo','questions','totalAppliedJob','isApplied'];    
        $condition = [['status','=',1],['category_id','=',1],['job_status','=',1],['country_id','=',14]];
        $condition1 = '';
        $relationTbl = '';
        $condition2 = '';
        $relationTbl2 = '';
        $whereinField = '';
        $whereCond = '';
        $whereinLikeField = '';
        $whereLikeCond = '';
        
        if((isset($data['company'])) && ($data['company'] == 1) && (isset($data['position_name'])) && ($data['position_name'] != '')){
            $whereinLikeField = 'title';
            $whereLikeCond = $data['position_name'];
        }
        if(request()->input('job_id',false) != false){
            $condition [] = ['job_id','=',$data['job_id']];
        }
        if((isset($data['company'])) && ($data['company'] == 2) && (request()->input('city_comp',false) != false)){
            $condition [] = ['city','=', $data['city_comp']];
        }
        if((isset($data['company'])) && ($data['company'] == 1) && (request()->input('city',false) != false)){
            $condition [] = ['city','=', $data['city']];
        }
        if(request()->input('citySearch',false) != false){
            $condition [] = ['city','LIKE','%'.$data['citySearch'].'%'];
        }
        // if((isset($data['company'])) && ($data['company'] == 1) && (request()->input('country_id',false) != false)){
        //     $condition [] = ['country_id','=',$data['country_id']];
        // }
        // else if((isset($data['company'])) && ($data['company'] == 2) && (request()->input('country_id_search_company',false) != false)){
        //     $condition [] = ['country_id','=',$data['country_id_search_company']];
        // }
        // else if(empty($data)){
        //     $condition [] = ['country_id','=',14]; 
        // }
        //$condition [] = ['country_id','=',14];
        /* if((isset($data['company'])) && ($data['company'] == 1) && (request()->input('state',false) != false)){
            $condition1  = [['state_id','=',$data['state']]];
            $relationTbl = 'postState';
        }else if((isset($data['company'])) && ($data['company'] == 2) && (request()->input('state_comp',false) != false)){
            $condition1  = [['state_id','=',$data['state_comp']]];
            $relationTbl = 'postState';
        }  */
        if((isset($data['company'])) && ($data['company'] == 2) && (request()->input('company_name',false) != false)){
            $condition2  = [['company_name','=',$data['company_name']]];
            $relationTbl2 = 'company';
        } 
        //dd($condition);
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $userId = 0;
        if(Auth::check()){
            $userId = Auth::user()->id;
        }

        $blockUserIds = $this->getMyBlockIds($userId);
        $blockUserByMe = $this->getBlockByMeIds($userId);
        $whereNotIn = array_merge($blockUserIds,$blockUserByMe);
        $reportedPost = $this->getAllReportedPost();
        $jobPost = $this->jobPost->getSearchWithRelationAll($condition,$condition1,$limit,$relations,$relationTbl,$condition2,$relationTbl2,$whereinField,$whereCond,$whereNotIn,$reportedPost,$whereinLikeField,$whereLikeCond);
        //dd($jobPost);
        return $jobPost;
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function jobDetails($request){ 
        $jobId = $request['id'];     
        $condition = [['id','=',$jobId]];
        $relations = ['company','country','postState','selectedSkill','cmsBasicInfo','questions','isApplied'];
        $jobPost = $this->jobPost->showWith($condition,$relations);
        return $jobPost;
    }

    /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function jobAlert($request)
    {
        $update['is_notification_on'] = $request['isSelected'];
        $id = Auth::user()->id;
        $candidateInfo = $this->user->update($update,$id);
        $this->userJobAlertHistory->deleteWhere(['user_id'=>$id]);
        if($candidateInfo){
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
    }
    /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function applyJobStoreInfo($request){
        $jobId = $request['job_id'];
        $userId = Auth::user()->id;
        if(Auth::user()->is_payment_done == 2){
            $a = $this->storeHighlightSentence($request);
        }
        if(!isset($request['job_applied_id']) || ($request['job_applied_id'] == '')){
            $applyCond['job_id'] = $jobId;
            $applyCond['user_id'] = $userId;
            $chkIsSaved = $this->jobApplied->findSingleRow($applyCond);
            if(!empty($chkIsSaved)){
                $this->jobApplied->delete($chkIsSaved['id']);
            }
            $insertDataJobApply = [];
            $insertDataJobApply['job_id'] = $request['job_id'];
            $insertDataJobApply['user_id'] = $userId;
            $insertDataJobApply['applied_status'] = 1;
            $storeJobApply = $this->jobApplied->create($insertDataJobApply);
            if($request->file('file')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                $this->deleteOldCv($userId, $jobId);
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                $uploadResponse  = $this->uploadService->file_upload($path,'user_cv',$request);
                if($uploadResponse['success']){
                    $options["file_name"] = $uploadResponse['file_name'];
                    $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                    $options["uploads_type"] = 'file';
                    $options["user_id"] = $userId;
                    $options["description"] = "CV uploaded successfully";
                    $options["type_id"] = $userId;
                    $options["job_id"] = $jobId;
                    $options["type"] = 'user_cv';
                    $options["org_name"] = $uploadResponse['org_name'];
                    $this->uploadService->createUploadsProfile($options);
                    $response = $options;
                }
            }
            if($request->file('additional_doc')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                // $this->deleteOldDoc($userId);
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                foreach($request->file('additional_doc') as $key => $value)
                {
                    $uploadResponse  = $this->uploadService->other_doc_upload($path, 'user_other_doc', $request, $key);
                    if($uploadResponse['success']){
                        $options["file_name"] = $uploadResponse['file_name'];
                        $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                        $options["uploads_type"] = 'file';
                        $options["user_id"] = $userId;
                        $options["description"] = "Other doc uploaded successfully";
                        $options["type_id"] = $userId;
                        $options["type"] = 'user_other_doc';
                        $options["job_id"] = $jobId;
                        $options["org_name"] = $uploadResponse['org_name'];
                        $this->uploadService->createUploadsProfile($options);
                        $response = $options;
                    }
                }
            }
            $insertData = [];
            $insertData['job_applied_id'] = $storeJobApply->id;
            $insertData['user_id'] = $userId;
            $insertData['job_id'] = $jobId;
            $insertData['cover_letter'] = $request['cover_letter'];
            $insertData['user_phone'] = $request['phone'];
            $insertData['user_city'] = $request['city'];
            $insertData['user_state'] = $request['state'];
            $insertData['user_country'] = $request['country'];
            $store = $this->candidateJobApplyInfo->create($insertData);
            
            return $storeJobApply->id;
        }else{
            $applyCond['job_id'] = $jobId;
            $applyCond['user_id'] = $userId;
            $chkIsSaved = $this->jobApplied->findSingleRow($applyCond);
            if(!empty($chkIsSaved)){
                $this->jobApplied->delete($chkIsSaved['id']);
            }
            $insertDataJobApply = [];
            $insertDataJobApply['job_id'] = $request['job_id'];
            $insertDataJobApply['user_id'] = $userId;
            $insertDataJobApply['applied_status'] = 1;
            $storeJobApply = $this->jobApplied->create($insertDataJobApply);
            // dd($storeJobApply);
            if($request->file('file')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                $this->deleteOldCv($userId, $jobId);
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                $uploadResponse  = $this->uploadService->file_upload($path,'user_cv',$request);
                if($uploadResponse['success']){
                    $options["file_name"] = $uploadResponse['file_name'];
                    $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                    $options["uploads_type"] = 'file';
                    $options["user_id"] = $userId;
                    $options["description"] = "CV uploaded successfully";
                    $options["type_id"] = $userId;
                    $options["job_id"] = $jobId;
                    $options["type"] = 'user_cv';
                    $options["org_name"] = $uploadResponse['org_name'];
                    $this->uploadService->createUploadsProfile($options);
                    $response = $options;
                }
            }
            if($request->file('additional_doc')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                // $this->deleteOldDoc($userId);
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                foreach($request->file('additional_doc') as $key => $value)
                {
                    $uploadResponse  = $this->uploadService->other_doc_upload($path, 'user_other_doc', $request, $key);
                    if($uploadResponse['success']){
                        $options["file_name"] = $uploadResponse['file_name'];
                        $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                        $options["uploads_type"] = 'file';
                        $options["user_id"] = $userId;
                        $options["description"] = "Other doc uploaded successfully";
                        $options["type_id"] = $userId;
                        $options["job_id"] = $jobId;
                        $options["type"] = 'user_other_doc';
                        $options["org_name"] = $uploadResponse['org_name'];
                        $this->uploadService->createUploadsProfile($options);
                        $response = $options;
                    }
                }
            }
            $insertData = [];
            $insertData['job_applied_id'] = $storeJobApply->id;
            $insertData['user_id'] = $userId;
            $insertData['job_id'] = $jobId;
            $insertData['cover_letter'] = $request['cover_letter'];
            $insertData['user_phone'] = $request['phone'];
            $insertData['user_city'] = $request['city'];
            $insertData['user_state'] = $request['state'];
            $insertData['user_country'] = $request['country'];
            $cond['job_applied_id'] = $insertData['job_applied_id'];
            $store = $this->candidateJobApplyInfo->updateMultipleRows($insertData,$cond);
            return $insertData['job_applied_id'];
        }
        
    }
     /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function getAppliedJobDetails($jobId,$userId){
        $condition = [];
        $condition['job_id'] = $jobId;
        $condition['user_id'] = $userId;
        $relation = ['country','state','city'];
        $appliedDetails = $this->candidateJobApplyInfo->showWith($condition,$relation);
        return $appliedDetails;
    }
    
    /**
     * Get all Applied Job
     */
    public function updateApplyJobInfo($request){
        $jobId = $request['job_id'];
        $userId = Auth::user()->id;
        if(isset($request['job_applied_id']) || ($request['job_applied_id'] != '')){
            $applyCond['job_id'] = $jobId;
            $applyCond['user_id'] = $userId;
            $storeJobApply = $this->jobApplied->findSingleRow($applyCond);
            if($request->file('file')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                $this->deleteOldCv($userId, $jobId);
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                $uploadResponse  = $this->uploadService->file_upload($path,'user_cv',$request);
                if($uploadResponse['success']){
                    $options["file_name"] = $uploadResponse['file_name'];
                    $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                    $options["uploads_type"] = 'file';
                    $options["user_id"] = $userId;
                    $options["description"] = "CV uploaded successfully";
                    $options["type_id"] = $userId;
                    $options["job_id"] = $jobId;
                    $options["type"] = 'user_cv';
                    $options["org_name"] = $uploadResponse['org_name'];
                    $this->uploadService->createUploadsProfile($options);
                    $response = $options;
                }
            } elseif($request->is_delete_cv == '1') {
                $this->deleteOldCv($userId, $jobId);
            }
            $this->deleteOldDoc($userId, $request);
            if($request->file('additional_doc')){
                $path    = '/upload/candidate'."/".$userId;
                $pathWeb = '/upload/candidate'."/".$userId;
                $directoryStatus = $this->uploadService->createDirecrotory($path);
                foreach($request->file('additional_doc') as $key => $value)
                {
                    $uploadResponse  = $this->uploadService->other_doc_upload($path, 'user_other_doc', $request, $key);
                    if($uploadResponse['success']){
                        $options["file_name"] = $uploadResponse['file_name'];
                        $options["location"] =  $pathWeb.'/'.$uploadResponse['file_name'];
                        $options["uploads_type"] = 'file';
                        $options["user_id"] = $userId;
                        $options["description"] = "Other doc uploaded successfully";
                        $options["type_id"] = $userId;
                        $options["type"] = 'user_other_doc';
                        $options["job_id"] = $jobId;
                        $options["org_name"] = $uploadResponse['org_name'];
                        $this->uploadService->createUploadsProfile($options);
                        $response = $options;
                    }
                }
            }
            $insertData = [];
            $insertData['job_applied_id'] = $storeJobApply->id;
            // $insertData['user_id'] = $userId;
            // $insertData['job_id'] = $jobId;
            $insertData['cover_letter'] = $request['cover_letter'];
            // $insertData['user_phone'] = $request['phone'];
            // $insertData['user_city'] = $request['city'];
            // $insertData['user_state'] = $request['state'];
            // $insertData['user_country'] = $request['country'];
            $cond['job_applied_id'] = $insertData['job_applied_id'];
            $store = $this->candidateJobApplyInfo->updateMultipleRows($insertData,$cond);
            
            return $storeJobApply->id;
        }
    }

    /**
     * Delete Applications
     */
    public function deleteApplication($request)
    {
        $jobId = $request->id;
        $userId = Auth::user()->id;
        
        $jobApplied = JobApplied::where('user_id', $userId)->where('job_id', $jobId)->get();
        $candidateJobApplyInfo = CandidateJobApplyInfo::where('user_id', $userId)->where('job_id', $jobId)->get();
        foreach($jobApplied as $job)
        {
            $job->delete();
        }
        foreach($candidateJobApplyInfo as $job)
        {
            $job->delete();
        }
        return 1;
    }

    public function saveJob($request){
        $data = $request->all();
        if($data['saveType'] == 1){
            $insertDataJobApply = [];
            $insertDataJobApply['job_id'] = $data['id'];
            $insertDataJobApply['user_id'] = Auth::user()->id;
            $insertDataJobApply['applied_status'] = 0;
            $storeJobApply = $this->jobApplied->create($insertDataJobApply);
            return 1;
        }else{
            $applyCond['job_id'] = $data['id'];
            $applyCond['user_id'] = Auth::user()->id;
            $chkIsSaved = $this->jobApplied->findSingleRow($applyCond);
            if(!empty($chkIsSaved)){
                $this->jobApplied->delete($chkIsSaved['id']);
            }
            //GET SAVE JOB COUNT 
            $status = 0;
            $userId = Auth::user()->id;
            $jobList = JobApplied::where([['user_id',$userId],['applied_status',$status]])->with('jobPost','appliedUserInfo');
            $jobList = $jobList->whereHas('jobPost',function($q){
                $q->where('status',1);
            });
            $jobList = $jobList->orderBy("id","DESC")->get()->count();

            return $jobList;
        }
        
    }

    /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function applyJobStoreSpecificAns($request){
        $jobAppliedId = $this->applyJobStoreInfo($request);
        $userId = Auth::user()->id;
        $cond['job_applied_id'] = $jobAppliedId;
        $cond['type'] = 1;
        $chkExistData = $this->userJobAppliedAnswers->getAll($cond);
        if(!empty($chkExistData)){
            $this->userJobAppliedAnswers->deleteRows($cond);
        }
        if($request['answer_1'] != null){
            $insertData1 = [];
            $insertData1['job_applied_id'] = $jobAppliedId;
            $insertData1['job_post_specific_questions_id'] = $request['question_id_1'];
            $insertData1['answer'] = $request['answer_1'];
            $insertData1['type'] = 1;
            
            $store1 = $this->userJobAppliedAnswers->create($insertData1);
        }
        if($request['answer_2'] != null){
            $insertData2 = [];
            $insertData2['job_applied_id'] = $jobAppliedId;
            $insertData2['job_post_specific_questions_id'] = $request['question_id_2'];
            $insertData2['answer'] = $request['answer_2'];
            $insertData2['type'] = 1;
            
            $store2 = $this->userJobAppliedAnswers->create($insertData2);
        }
        if($request['answer_3'] != null){
            $insertData3 = [];
            $insertData3['job_applied_id'] = $jobAppliedId;
            $insertData3['job_post_specific_questions_id'] = $request['question_id_3'];
            $insertData3['answer'] = $request['answer_3'];
            $insertData3['type'] = 1;
            
            $store3 = $this->userJobAppliedAnswers->create($insertData3);
        }
        if($request['video_answer_1'] != null){
          $insertData4 = [];
          $insertData4['job_applied_id'] = $jobAppliedId;
          $insertData4['job_post_specific_questions_id'] = $request['video_question_id_1'];
          $insertData4['answer'] = $request['video_answer_1'];
          $insertData4['type'] = 2;
          
          $store4 = $this->userJobAppliedAnswers->create($insertData4);
      }
        return $jobAppliedId;
        
    }

     /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function getAppliedAnswer($jobAppliedId){
        $condition = [];
        $condition['job_applied_id'] = $jobAppliedId;
        $condition['type'] = 1;
        $appliedDetails = $this->userJobAppliedAnswers->getAll($condition);
        return $appliedDetails;
    }

     /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function getAppliedVideoAnswer($jobAppliedId){
        $condition = [];
        $condition['job_applied_id'] = $jobAppliedId;
        $condition['type'] = 2;
        $with = 'upload';
        $appliedDetails = $this->userJobAppliedAnswers->getWith($condition,'',$with);
        return $appliedDetails;
    }
    /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function applyJobStoreAllInfo($request){
        $jobAppliedId = $this->applyJobStoreSpecificAns($request);
        if($jobAppliedId){
            $update = [];
            $update['applied_status'] = 2;
            $update['apply_date'] = date('Y-m-d H:i:s');
            $storeJobApply = $this->jobApplied->update($update,$jobAppliedId);
            return $jobAppliedId;
        }else{
            return 0;
        }
        
    }

    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function trackJobList($search){ 
        
        $status = $search['status'];
        $userId = Auth::user()->id;
        $jobList = JobApplied::where([['user_id',$userId],['applied_status',$status]])->with('jobPost','appliedUserInfo');
        $jobList = $jobList->whereHas('jobPost',function($q){
            $q->where([['status','=',1],['job_status','!=',0]]);
        });
        $jobList = $jobList->orderBy("id","DESC");
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $page = $search['page'];
        $skip = $limit * ($page - 1);
        $jobList = $jobList->skip($skip)->take($limit)->get();
       //dd($jobList);
        return $jobList;
    }
    /**
    * Function to get All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function getAllDraftJob(){ 
        
        $jobList = JobApplied::where([['applied_status',1]])->with('jobPost');
        $jobList = $jobList->whereHas('jobPost',function($q){
            $date = date('Y-m-d', strtotime("-1 days"));
            $startToday = date('Y-m-d',strtotime($date));
            $startToday    = Carbon::parse($startToday)
                    ->startOfDay()        // 2018-09-29 00:00:00.000000
                    ->toDateTimeString();

            $filterDataStart = date('Y-m-d',strtotime($date. ' + 3 days')); // IF END DATE AFTER 2 DAY
            $enddayStart    = Carbon::parse($filterDataStart)
                    ->startOfDay()        // 2018-09-29 00:00:00.000000
                    ->toDateTimeString();
                    //$to = $to . " 12:59:59";
                  
            $filterData = date('Y-m-d',strtotime($date. ' + 3 days')); // IF END DATE AFTER 2 DAY
            $endday    = Carbon::parse($filterData)
                    ->endOfDay()        // 2018-09-29 00:00:00.000000
                    ->toDateTimeString();
                    //$to = $to . " 12:59:59";
                   
            $condition [] = ['start_date','<=',$startToday];
            $condition [] = ['end_date','>=',$enddayStart]; // NEED OR 2 DAYS TO EXPIER THE JOB
            $condition [] = ['end_date','<=',$endday]; // NEED OR 2 DAYS TO EXPIER THE JOB
            $condition [] = ['job_status','!=',0]; // NEED OR 2 DAYS TO EXPIER THE JOB
            $condition [] = ['status','=',1]; // ACTIVE JOB
            $q->where($condition);
        });
        $jobList = $jobList->orderBy("id","DESC")->get()->toArray();
       
        return $jobList;
    }
    /**
    * Function to add to cron master tbl All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function addToCronJob($saveAsDraftJobs){
        if(!empty($saveAsDraftJobs)){
            foreach($saveAsDraftJobs as $key=>$val){
                $data['to_user_id'] = $val['user_id'];
                $data['from_user_id'] = $val['job_post']['user_id'];
                $data['type_id'] = $val['id'];
                $data['type'] = 'reminder_save_as_draft_job';
                $cronjobs = $this->cronJobMaster->create($data);
            }
        }
        
    }
    /**
    * Function to add to cron master tbl All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function sendMailToCandidate($type){
        $condition = [];
        $condition['type'] = $type;
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $relations = ['toUser','fromUser','jobPost','appliedUserInfo'];
        $appliedDetails = $this->cronJobMaster->getWith($condition, $limit, $relations);
       
        if(!empty($appliedDetails)){
            foreach($appliedDetails as $key=>$val){
                $blockStatus = $this->userBlock->checkBlockUser($val['to_user_id'],$val['from_user_id']);
                $toUserStatus = $this->user->findSingleRow(['id'=>$val['to_user_id'],'status'=>1]);
               
                if((empty($blockStatus)) && (!empty($toUserStatus))){
                    $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
                    $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
                    $dataMail['imgPath'] = $imgPath;
                    $dataMail['logoPath'] = $logoPath;
                    $dataMail['details'] = $val;
                    try {
                        $mail = Mail::to($val['toUser']['email'])->send(new ReminderDraftJob($dataMail));
                        $this->cronJobMaster->delete($val['id']);
                    } catch (Exception $ex) {
                        // Debug via $ex->getMessage();
                        //return "We've got errors!";
                    }
                }
            }
            
        }
        
    }

    /**
    * Function to get All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function getAllNewJob(){ 
        
        $relations = ['company','country','postState'];    
        $condition = [['status','=',1],['category_id','=',1]];
        $condition1 = '';
        
        $date = date('Y-m-d', strtotime("-1 days"));
        $startToday = date('Y-m-d',strtotime($date));
        $startToday    = Carbon::parse($startToday)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();

        $filterDataEnd = date('Y-m-d',strtotime($date));
        $endToday    = Carbon::parse($filterDataEnd)
                ->endOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();
                //$to = $to . " 12:59:59";

        $condition [] = ['start_date','>=',$startToday];
        $condition [] = ['start_date','<=',$endToday];
        
        $limit = '';
        $jobPost = $this->jobPost->getSearchWithRelationAll($condition,$condition1,$limit,$relations);
        return $jobPost;
    }

    /**
    * Function to add to cron master tbl All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function addToCronJobAlert(){
        
        $allAlertSettingData = UserJobAlertHistory::orderBy('user_id','ASC')
                                                    ->get()
                                                    ->toArray();
        if(!empty($allAlertSettingData)){
            $key = 0;
            $cronTblData = [];
            foreach($allAlertSettingData as $i=>$val){
                $keyword = $val['keyword']; 
                $countryId = '';
                $stateId = '';
                if($val['country_id'] != '' || $val['country_id'] != null){
                    $countryId = $val['country_id'];
                }  
                if($val['state_id'] != '' || $val['state_id'] != null){
                    $stateId = $val['state_id'];
                }  
                $relations = ['company','country','postState','selectedSkill','cmsBasicInfo'];
                $date = date('Y-m-d', strtotime("-1 days"));
                $startToday = date('Y-m-d',strtotime($date));
                $startToday = Carbon::parse($startToday)
                                ->startOfDay()        // 2018-09-29 00:00:00.000000
                                ->toDateTimeString();

                $filterDataEnd = date('Y-m-d',strtotime($date));
                $endToday    = Carbon::parse($filterDataEnd)
                                ->endOfDay()        // 2018-09-29 00:00:00.000000
                                ->toDateTimeString();
                        //$to = $to . " 12:59:59";
                if($val['type'] == 1){
                    if($countryId != ''){
                        $jobList = JobPost::where([['title','Like','%'.$keyword.'%'],['country_id','=',$countryId],['status','=',1],['category_id','=',1],['start_date','>=',$startToday],['start_date','<=',$endToday]])
                                        ->with($relations);
                    }else{
                        $jobList = JobPost::where([['title','Like','%'.$keyword.'%'],['status','=',1],['category_id','=',1],['start_date','>=',$startToday],['start_date','<=',$endToday]])
                                        ->with($relations);
                    }
                    if($stateId != ''){
                        $jobList = $jobList->whereHas('postState',function($q) use ($stateId){
                            $q->where([['state_id','=', $stateId]]);
                        }); 
                    }
                                         
                    $jobList = $jobList->orderBy("id","ASC")
                                        ->get()
                                        ->toArray();
                }else if($val['type'] == 2){
                    if($countryId != ''){
                        $jobList = JobPost::where([['country_id','=',$countryId],['status','=',1],['category_id','=',1],['start_date','>=',$startToday],['start_date','<=',$endToday]])
                                        ->with($relations);
                    }else{
                        $jobList = JobPost::where([['status','=',1],['category_id','=',1],['start_date','>=',$startToday],['start_date','<=',$endToday]])
                                        ->with($relations);
                    }
                    $jobList = $jobList->whereHas('company',function($q) use ($keyword){
                                    $q->where([['company_name','=', $keyword]]);
                    });  
                    if($stateId != ''){
                        $jobList = $jobList->whereHas('postState',function($q) use ($stateId){
                            $q->where([['state_id','=', $stateId]]);
                        });
                    }
                                       
                    $jobList = $jobList->orderBy("id","ASC")
                                        ->get()
                                        ->toArray();
                }
                if(!empty($jobList)){
                    $jobCount = count($jobList);
                    if($key == 0){
                        $cronTblData[$key]['to_user_id'] = $val['user_id'];
                        $cronTblData[$key]['from_user_id'] = $jobList[0]['user_id'];
                        $cronTblData[$key]['type'] = 'job_post_alert';
                        $cronTblData[$key]['job_count'] = count($jobList);
                        if($jobCount > 1){
                            $cronTblData[$key]['type_id'] = $jobList[0]['id'].','.$jobList[1]['id'];
                        }else{
                            $cronTblData[$key]['type_id'] = $jobList[0]['id'];
                        }
                    }else{
                        $prevUser = $cronTblData[$key-1]['to_user_id'];
                        $prevJobCount = count(explode(",",$cronTblData[$key-1]['type_id']));
                        $prevTypeId = $cronTblData[$key-1]['type_id'];
                       
                        if(($prevUser == $val['user_id']) && ($prevJobCount < 2) && ($prevTypeId != $jobList[0]['id'])){
                            $cronTblData[$key-1]['type_id'] = $cronTblData[$key-1]['type_id'].','.$jobList[0]['id'];
                            $cronTblData[$key-1]['job_count'] = $cronTblData[$key-1]['job_count'] + count($jobList);
                        }else if($prevUser != $val['user_id']){
                            $cronTblData[$key]['to_user_id'] = $val['user_id'];
                            $cronTblData[$key]['from_user_id'] = $jobList[0]['user_id'];
                            $cronTblData[$key]['type'] = 'job_post_alert';
                            $cronTblData[$key]['job_count'] = count($jobList);
                            if($jobCount > 1){
                                $cronTblData[$key]['type_id'] = $jobList[0]['id'].','.$jobList[1]['id'];
                            }else{
                                $cronTblData[$key]['type_id'] = $jobList[0]['id'];
                            }
                        }
                    }
                    $key++;
                }
                
            }
            if(!empty($cronTblData)){
                $cronjobs = $this->cronJobMaster->multipleRowInsert($cronTblData);
            }
            return 1;

        }                                            
        
    }
    /**
     * Funcion to get candidate's following ids
     * @param integer $userId
     * @return array $followingIds
     */
     public function getMyFollowersIds($userId)
     {
        $followingIds = [0];
        $conditions = [['follower_id','=',$userId]];
        $myFollowing = $this->userFollowers->getAll($conditions);
        if($myFollowing->isNotEmpty()){
            foreach ($myFollowing as $key => $row) {
                      $followingIds[] = $row->user_id;
            }
        }
        return $followingIds;
     }
     /**
     * Funcion to get all companies ids
     * @return array $companiesIds
     */
     public function getAllCopanyIds()
     {
        $companiesLists = [0];
        $conditions = [['user_type','=','3'],['status','=','1']];
        $cmpylist = $this->user->getAll($conditions);
        if($cmpylist->isNotEmpty()){
            foreach ($cmpylist as $key => $row) {
                      $companiesLists[] = $row->id;
            }
        }
        return $companiesLists;
     }
     /**
     * Funcion to get candidate's connection's ids
     * @param integer $userId
     * @return array $followingIds
     */
     public function getMyConnectionsIds($userId)
     {
        $myConnectionsIds = [0];
        $conditions = [['request_sent_by','=',$userId],['status','=',1]];
        $myConnections = $this->userConnection->getAll($conditions);
        if($myConnections->isNotEmpty()){
            foreach ($myConnections as $key => $row) {
                      $myConnectionsIds[] = $row->request_accepted_by;
            }
        }
        return $myConnectionsIds;
     }
     /**
     * Funcion to get candidate's connection's ids
     * @param integer $userId
     * @return array $followingIds
     */
    public function getMyConnectionsAcceptIds($userId)
    {
       $myConnectionsIds = [0];
       $conditions = [['request_accepted_by','=',$userId],['status','=',1]];
       $myConnections = $this->userConnection->getAll($conditions);
       if($myConnections->isNotEmpty()){
           foreach ($myConnections as $key => $row) {
                     $myConnectionsIds[] = $row->request_sent_by;
           }
       }
       return $myConnectionsIds;
    }
     /**
     * Funcion to get candidate's connection's ids
     * @param integer $userId
     * @return array $followingIds
     */
    public function getMyBlockIds($userId)
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
    public function getBlockByMeIds($userId)
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
    * Function to add to cron master tbl All Draft Job
    * @param Illuminate\Http\Request $request
    * @return array obj $companyPost
    */
    public function sendJobAlertMailToCandidate($type){
        $condition = [];
        $condition['type'] = $type;
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $relations = ['toUser','fromUser'];
        $appliedDetails = $this->cronJobMaster->getWith($condition, $limit, $relations);
       
        if(!empty($appliedDetails)){
            foreach($appliedDetails as $key=>$val){
                $blockStatus = $this->userBlock->checkBlockUser($val['to_user_id'],$val['from_user_id']);
                $toUserStatus = $this->user->findSingleRow(['id'=>$val['to_user_id'],'status'=>1]);
               
                if((empty($blockStatus)) && (!empty($toUserStatus))){
                    $jobIds = explode(",",$val['type_id']);
                    $condition1['status'] = 1;
                    $relations = ['company','country','postState','cmsBasicInfo'];
                    $whereInField = 'id';
                    $whereInArr = $jobIds;
                    $val['job_details'] = $this->jobPost->showWithWhereIn($condition1,$relations,$whereInField,$whereInArr);
                    $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
                    $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
                    $dataMail['imgPath'] = $imgPath;
                    $dataMail['logoPath'] = $logoPath;
                    $dataMail['details'] = $val;
                    try {
                        $mail = Mail::to($val['toUser']['email'])->send(new JobAlertSettingMail($dataMail));
                        $this->cronJobMaster->delete($val['id']);
                    } catch (Exception $ex) {
                        // Debug via $ex->getMessage();
                        //return "We've got errors!";
                    }
                }

            }
            
        }
        
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
        $notInId = $this->getBlockByMeIds($userId);
        $wherHasTbl = 'user';
        $wherHasCon = [['status',1]];
        $followers = $this->userFollowers->getWithCondition($condition,$limit,$relations,$wherHasTbl,$wherHasCon,$notInId);
        return $followers;
    } 

    public function jobAlertHistory($search){
        //return $search;
        if((isset($search['company'])) && ($search['company'] == 2)){
            $alertHistory = [];
            $alertHistory['user_id'] = Auth::user()->id;
            $alertHistory['type'] = 2;
            $alertHistory['keyword'] = ucwords($search['company_name']);
            //$alertHistory['country_id'] = $search['country_id_search_company'];
            if(isset($search['state_comp']) && $search['state_comp'] != null){
                $alertHistory['state_id'] = $search['state_comp'];
            }
            if(isset($search['city_comp']) && $search['city_comp'] != null){
                $alertHistory['city'] = $search['city_comp'];
            }
            $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
            if(($chkExist != null) && ($chkExist->count() > 0)){
                $del = $this->userJobAlertHistory->delete($chkExist['id']);  
            }
            $result = $this->userJobAlertHistory->create($alertHistory);
            return $result;
        }else if((isset($search['company'])) && ($search['company'] == 1)){
            if(isset($search['position_name']) && $search['position_name'] != null){
                foreach($search['position_name'] as $key=>$val){
                    $alertHistory = [];
                    $alertHistory['user_id'] = Auth::user()->id;
                    $alertHistory['type'] = 1;
                    $alertHistory['keyword'] = ucwords($val);
                    //$alertHistory['country_id'] = $search['country_id'];
                    if(isset($search['state']) && $search['state'] != null){
                        $alertHistory['state_id'] = $search['state'];
                    }
                    if(isset($search['job_id']) && $search['job_id'] != null){
                        $alertHistory['job_id'] = $search['job_id'];
                    }
                    if(isset($search['city']) && $search['city'] != null){
                        $alertHistory['city'] = $search['city'];
                    }
                    $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                    if(($chkExist != null) && ($chkExist->count() > 0)){
                        $del = $this->userJobAlertHistory->delete($chkExist['id']);  
                    }
                    $result = $this->userJobAlertHistory->create($alertHistory);
                }
                return $result;
            }else if(isset($search['state']) && $search['state'] != null){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['state_id'] = $search['state'];
                if(isset($search['job_id']) && $search['job_id'] != null){
                    $alertHistory['job_id'] = $search['job_id'];
                }
                if(isset($search['city']) && $search['city'] != null){
                    $alertHistory['city'] = $search['city'];
                }
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    $del = $this->userJobAlertHistory->delete($chkExist['id']);  
                }
                $result = $this->userJobAlertHistory->create($alertHistory);
                return $result;
            }
            else if(isset($search['city']) && $search['city'] != null){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['city'] = $search['city'];
                if(isset($search['state']) && $search['state'] != null){
                    $alertHistory['state_id'] = $search['state'];
                }
                if(isset($search['job_id']) && $search['job_id'] != null){
                    $alertHistory['job_id'] = $search['job_id'];
                }
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    $del = $this->userJobAlertHistory->delete($chkExist['id']);  
                }
                $result = $this->userJobAlertHistory->create($alertHistory);
                return $result;
            }
            else if(isset($search['job_id']) && $search['job_id'] != null){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['job_id'] = $search['job_id'];
                if(isset($search['state']) && $search['state'] != null){
                    $alertHistory['state_id'] = $search['state'];
                }
                if(isset($search['city']) && $search['city'] != null){
                    $alertHistory['city'] = $search['city'];
                }
                $whereCon['job_id'] = $search['job_id'];
                $jobTitle = $this->jobPost->findSingleRow($whereCon);
                $alertHistory['keyword'] = $jobTitle['title'];
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    $del = $this->userJobAlertHistory->delete($chkExist['id']);  
                }
                $result = $this->userJobAlertHistory->create($alertHistory);
                return $result;
            }
            //return $result;
            
        }
        
        
    }

    public function getJobAlertHistory(){
        $userId = Auth::user()->id;
        $where['user_id'] = $userId;
        $with = ['state','country'];
        $limit = env('FRONTEND_PAGINATION_LIMIT');
        $alertList = $this->userJobAlertHistory->getWith($where,$limit,$with);
        return $alertList;
    }

     /**
     * Function to delete post
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function deleteJobAlert($request)
    {
        $id = $request['id'];
        $status = $this->userJobAlertHistory->delete($id);  
        if($status){
            //GET COUNT ALERT SETTING
            $userId = Auth::user()->id;
            $where['user_id'] = $userId;
            $with = ['state','country'];
            $alertList = $this->userJobAlertHistory->getWith($where,'',$with);
            $allCount = $alertList->count();
            $response = $allCount;
            //$response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
    }
    /**
     * Function to change status of job for cron
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function changeJobStatus(){
        $date = date('d-m-Y');
        $startToday = date('Y-m-d',strtotime($date));
        $startToday    = Carbon::parse($startToday)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();

        $endToday = date('Y-m-d',strtotime($date));
        $endToday    = Carbon::parse($endToday)
                ->endOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();
                //$to = $to . " 12:59:59";      
        $where = [['category_id',1],['job_status',0],['start_date','>=',$startToday],['start_date','<=',$endToday]]; 
        //GET ALL PENDING JOB FIRST
        $pendingStatusJob = $this->jobPost->getAll($where)->toArray();
        //THEN UPDATE
        $update['job_status'] = 1;      // ONGOING
        $pendingStatus = $this->jobPost->updateMultipleRows($update,$where);

        $where1 = [['category_id',1],['end_date','<',$startToday]]; 
        $update1['job_status'] = 2;   // CLOSED   
        $ongoingStatus = $this->jobPost->updateMultipleRows($update1,$where1);

        //SENT MAIL TO CANDIDATE FOR ONGOING JOB
        if(($pendingStatus != '') && (!empty($pendingStatusJob))){
            foreach($pendingStatusJob as $jobkey=>$job){
                $userId = $job['user_id'];
                $cond = [];
                $cond['user_id'] = $userId;
                $relation = 'user';
                $blockUserIds = $this->getMyBlockIds($userId);
                $blockUserByMe = $this->getBlockByMeIds($userId);
                $whereNotIn = array_merge($blockUserIds,$blockUserByMe);
                //$whereNotIn = $this->getWhomBlockByMeIds($userId);
                $followers = $this->userFollowers->getAllUnblockFollower($cond,$relation,$whereNotIn,'');
                
                if(!empty($followers)){
                    foreach($followers as $key=>$val){
                        $notification = [];
                        $notification['type'] = 'job';
                        $notification['type_id'] = $job['id'];
                        $notification['from_user_id'] = $userId;
                        $notification['to_user_id'] = $val['follower_id'];
                        $this->notification->create($notification);

                        $whereInArr = [];
                        $condition1['status'] = 1;
                        $relations = ['company','country','postState','cmsBasicInfo'];
                        $whereInField = 'id';
                        $whereInArr[0] = $job['id'];
                        $dataMail['job_details'] = $this->jobPost->showWithWhereIn($condition1,$relations,$whereInField,$whereInArr);
                        $toUser = $val['user'];
                        $dataMail['first_name'] = $toUser['first_name'];
                        $dataMail['details']['toUser'] = $toUser;
                        $conditions[] = ['id','=',$userId];
                        $fromUser = $this->user->findSingleRow($conditions);
                        $dataMail['details']['fromUser']['company_name'] = $fromUser['company_name'];
                        dispatch(new JobAlertNotification($dataMail));
                    }
                    
                }
            }
            
        }
        

        // TEST MAIL CRON JOB 
        $to_name = 'Rumpa Ghosh';
        $to_email = 'rumpa12tgb@gmail.com';
        $data = [];

        Mail::send('email/mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Laravel Test Mail Cron Job change status');
            $message->from('rumpa.g.unified@gmail.com','Test mail schedular');
        });
        // TEST MAIL CRON JOB 
        return $ongoingStatus;
    }

    public function getAllReportedPost(){
        $reportedPost = ReportedPost::where([['type' , 'post'],['status','!=',2]])->orderBy("id","ASC")->pluck('type_id')->all();
        return $reportedPost;
    }

    /**
     * Function to store intro video
     * @param Illuminate\Http\Request $request
     * @return json Response 
     */
    public function storeInterviewVideoAnswer($request)
    {

        $jobId = $request['job_id'];
        $userId = Auth::user()->id;
        $error = 0;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
        
        // APPLY JOB
        if($request['type'] == 1){
            $jobAppliedId = $this->applyJobStoreAllInfo($request);
        }
        // SAVE AS DRAFT JOB
        else if($request['type'] == 0){
            $jobAppliedId = $this->applyJobStoreSpecificAns($request);
        }

        if((isset($request['job_applied_id'])) && ($request['job_applied_id'] != '')){
            $request['job_applied_id'] = $request['job_applied_id'];
        }else{
            $request['job_applied_id'] = $jobAppliedId;
        }

        //SELECTED ATTEMPT UPLOAD
        if(isset($request['attempt_question_1']) && ($request['attempt_question_1'] != '')){
            $id = $request['attempt_question_1'];
            $chkExistData = $this->userInterviewAttempt->findSingleRow(['id' => $id]);

            if(!empty($chkExistData)){
                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_1'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData['filename'];
                    $options["location"] =  $chkExistData['location'];
                    $options["org_name"] = $chkExistData['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $insertData1 = [];
                    $insertData1['job_applied_id'] = $request['job_applied_id'];
                    $insertData1['job_post_specific_questions_id'] = $request['video_question_id_1'];
                    $insertData1['answer'] = 'First video uploaded';
                    $insertData1['type'] = 2;
                    
                    $store1 = $this->userJobAppliedAnswers->create($insertData1);

                    $options["file_name"] = $chkExistData['filename'];
                    $options["location"] =  $chkExistData['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store1->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData['job_id'];
                $descond['question_id'] = $chkExistData['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData['id']);
            }
        }else{
            $condi['user_id'] = $userId;
            $condi['job_id'] = $request['job_id'];
            $condi['question_id'] = $request['video_question_id_1'];
            $limit = 1;
            $chkExistData = $this->userInterviewAttempt->getLastVideoData($condi,$limit);
            
            if(!empty($chkExistData)){
                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_1'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData['filename'];
                    $options["location"] =  $chkExistData['location'];
                    $options["org_name"] = $chkExistData['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $insertData1 = [];
                    $insertData1['job_applied_id'] = $request['job_applied_id'];
                    $insertData1['job_post_specific_questions_id'] = $request['video_question_id_1'];
                    $insertData1['answer'] = 'First video uploaded';
                    $insertData1['type'] = 2;
                    
                    $store1 = $this->userJobAppliedAnswers->create($insertData1);

                    $options["file_name"] = $chkExistData['filename'];
                    $options["location"] =  $chkExistData['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store1->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData['job_id'];
                $descond['question_id'] = $chkExistData['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData['id']);
            }
        }
        //ATTEMPT ANSER UPLOAD SECOND

        if(isset($request['attempt_question_2']) && ($request['attempt_question_2'] != '')){
            $id = $request['attempt_question_2'];
            $chkExistData2 = $this->userInterviewAttempt->findSingleRow(['id' => $id]);
            if(!empty($chkExistData2)){

                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_2'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData2['filename'];
                    $options["location"] =  $chkExistData2['location'];
                    $options["org_name"] = $chkExistData2['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $insertData2 = [];
                    $insertData2['job_applied_id'] = $request['job_applied_id'];
                    $insertData2['job_post_specific_questions_id'] = $request['video_question_id_2'];
                    $insertData2['answer'] = 'Second video uploaded';
                    $insertData2['type'] = 2;
                    
                    $store2 = $this->userJobAppliedAnswers->create($insertData2);

                    $options["file_name"] = $chkExistData2['filename'];
                    $options["location"] =  $chkExistData2['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store2->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData2['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData2['job_id'];
                $descond['question_id'] = $chkExistData2['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData2['id']);
            }
        }else{
            $condi['user_id'] = $userId;
            $condi['job_id'] = $request['job_id'];
            $condi['question_id'] = $request['video_question_id_2'];
            $limit = 1;
            $chkExistData2 = $this->userInterviewAttempt->getLastVideoData($condi,$limit);
            
            if(!empty($chkExistData2)){

                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_2'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData2['filename'];
                    $options["location"] =  $chkExistData2['location'];
                    $options["org_name"] = $chkExistData2['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $applyAnsData = [];
                    $applyAnsData['job_applied_id'] = $request['job_applied_id'];
                    $applyAnsData['job_post_specific_questions_id'] = $request['video_question_id_2'];
                    $applyAnsData['answer'] = 'Second video uploaded';
                    $applyAnsData['type'] = 2;
                    
                    $store2 = $this->userJobAppliedAnswers->create($applyAnsData);

                    $options["file_name"] = $chkExistData2['filename'];
                    $options["location"] =  $chkExistData2['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store2->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData2['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData2['job_id'];
                $descond['question_id'] = $chkExistData2['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData2['id']);
            }
        }

        //ATTEMPT ANSER UPLOAD SECOND

        if(isset($request['attempt_question_3']) && ($request['attempt_question_3'] != '')){
            $id = $request['attempt_question_3'];
            $chkExistData3 = $this->userInterviewAttempt->findSingleRow(['id' => $id]);
             
            if(!empty($chkExistData3)){

                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_3'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData3['filename'];
                    $options["location"] =  $chkExistData3['location'];
                    $options["org_name"] = $chkExistData3['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $applyAnsData = [];
                    $applyAnsData['job_applied_id'] = $request['job_applied_id'];
                    $applyAnsData['job_post_specific_questions_id'] = $request['video_question_id_3'];
                    $applyAnsData['answer'] = 'Third video uploaded';
                    $applyAnsData['type'] = 2;
                    
                    $store3 = $this->userJobAppliedAnswers->create($applyAnsData);

                    $options["file_name"] = $chkExistData3['filename'];
                    $options["location"] =  $chkExistData3['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store3->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData3['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData3['job_id'];
                $descond['question_id'] = $chkExistData3['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData3['id']);
            }
        
        }else{
            $condi['user_id'] = $userId;
            $condi['job_id'] = $request['job_id'];
            $condi['question_id'] = $request['video_question_id_3'];
            $limit = 1;
            $chkExistData3 = $this->userInterviewAttempt->getLastVideoData($condi,$limit);
            if(!empty($chkExistData3)){
                $condUpdate['job_applied_id'] = $request['job_applied_id'];
                $condUpdate['job_post_specific_questions_id'] = $request['video_question_id_3'];
                $condUpdate['type'] = 2;
                $chkExistDataUpdate = $this->userJobAppliedAnswers->findSingleRow($condUpdate);
                if(!empty($chkExistDataUpdate)){
                    $condition [] = ['user_id','=',$userId];
                    $condition [] = ['type_id','=',$chkExistDataUpdate['id']];
                    $condition [] = ['type','=','user_interview_video'];

                    $options["name"] = $chkExistData3['filename'];
                    $options["location"] =  $chkExistData3['location'];
                    $options["org_name"] = $chkExistData3['filename'];
                    $this->uploadServiceCommon->updateMultipleRows($options,$condition);
                }else{
                    $applyAnsData = [];
                    $applyAnsData['job_applied_id'] = $request['job_applied_id'];
                    $applyAnsData['job_post_specific_questions_id'] = $request['video_question_id_3'];
                    $applyAnsData['answer'] = 'Third video uploaded';
                    $applyAnsData['type'] = 2;
                    
                    $store3 = $this->userJobAppliedAnswers->create($applyAnsData);

                    $options["file_name"] = $chkExistData3['filename'];
                    $options["location"] =  $chkExistData3['location'];
                    $options["uploads_type"] = 'video';
                    $options["user_id"] = $userId;
                    $options["description"] = "Interview video uploaded successfully";
                    $options["type_id"] = $store3->id;
                    $options["type"] = 'user_interview_video';
                    $options["org_name"] = $chkExistData3['filename'];
                    $this->uploadService->createUploadsProfile($options);
                }
                //DESELECT OTHERS
                $descond['user_id'] = $userId;
                $descond['job_id'] = $chkExistData3['job_id'];
                $descond['question_id'] = $chkExistData3['question_id'];
                $update = $this->userInterviewAttempt->updateMultipleRows(['is_selected' => 0],$descond);

                //UPDATE ATTEMPT VIDEO IS SELECTED
                $update = $this->userInterviewAttempt->update(['is_selected' => 1],$chkExistData3['id']);
            }
        }

        if($error > 0){
            $response = Response::json('error', 400);
        }else{
            // APPLY JOB
            if($request['type'] == 1){
                $condi['user_id'] = $userId;
                $condi['job_id'] = $request['job_id'];
                $chkExistData4 = $this->userInterviewAttempt->getAll($cond);
                if(!empty($chkExistData4)){
                    foreach($chkExistData4 as $key=>$val){
                        $ansTblId = $val['id'];
                        $this->userInterviewAttempt->delete($ansTblId);
                        if(Storage::disk('s3')->exists('/'.$val->filename)){
                            Storage::disk('s3')->delete('/'.$val->filename);
                        }
                    }
                    
                }
            }
            $response = $jobAppliedId;
        }
        
        return $response;
    }

    /**
     * Function to delete old CV
     * @param integer $userId
     * @return boolean $status
     */
    public function deleteOldInterviewVideo($ansId)
    {
        $userId = Auth::user()->id;
        $condition [] = ['user_id','=',$userId];
        $condition [] = ['type_id','=',$ansId];
        $condition [] = ['type','=','user_interview_video'];
        $uploadInfo = $this->uploadRepository->findSingleRow($condition);
        if($uploadInfo){             
            $this->uploadRepository->deleteWhere($condition);
            if(Storage::disk('s3')->exists('/'.$uploadInfo->name)){
                Storage::disk('s3')->delete('/'.$uploadInfo->name);
            }
        }
    }

    public function deleteInterviewVideo($request){
        $cond['job_applied_id'] = $request['applyid'];
        $cond['job_post_specific_questions_id'] = $request['questionid'];
        $cond['type'] = 2;
        $chkExistData = $this->userJobAppliedAnswers->findSingleRow($cond);
        if(!empty($chkExistData)){
            $ansTblId = $chkExistData['id'];
            $this->userJobAppliedAnswers->delete($ansTblId);
            $this->deleteOldInterviewVideo($ansTblId);
        }
        return $chkExistData;
    }

    public function storeInterviewAttempt($request){
       
        $jobId = $request['jobId'];
        $questionId = $request['questionId'];
        $insertData = [];
        $userId = Auth::user()->id;
        $path    = '/upload/candidate'."/".$userId;
        $pathWeb = '/upload/candidate'."/".$userId;
        
        if($request->file('file1')){
            $directoryStatus = $this->uploadService->createDirecrotory($path);
            $file = $request->file('file1');  
            $extension = "mp4";       
            $filename  = 'user_interview_attempt_'.time().".{$extension}";
            $org_name  =  $filename;
            //$upload_success = $file->storeAs($path,$filename);
            $upload_success = Storage::disk('s3')->put('/'.$filename, file_get_contents($file),'private');
            if($upload_success){
                $insertData['job_id'] = $jobId;
                $insertData['question_id'] = $questionId;
                $insertData["filename"] = $filename;
                $insertData["location"] =  env('AWS_IMG_VIEW_URL').$filename;
                $insertData["user_id"] = $userId;
                
                $store = $this->userInterviewAttempt->create($insertData);
                return $store->id;
            }
        }
        

    }

     /**
     * Function to update candidate job alert notification
     * @param string $is_jobalert_on
     * @return array $candidateInfo
     */
    public function getAttemptAnswer($jobId){
        $userId = Auth::user()->id;
        $condition = [];
        $condition['job_id'] = $jobId;
        $condition['user_id'] = $userId;
        $attemptDetails = $this->userInterviewAttempt->getAll($condition);
        return $attemptDetails;
    }

    public function getSelectedVideo($request){
        $attemtId = $request['attempt_id'];
        $condition = [];
        $condition['id'] = $attemtId;
        $attemptDetails = $this->userInterviewAttempt->findSingleRow($condition);
        //S3 BUCKET IMG
        $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
        $command = $adapter->getClient()->getCommand('GetObject', [
        'Bucket' => $adapter->getBucket(),
        'Key'    => $adapter->getPathPrefix(). '' . $attemptDetails['filename']
        ]);
        $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
        $path = (string)$img->getUri();
        $attemptDetails['location'] = $path;
        return $attemptDetails;
    }

    public function chkUserStatus($userId){
        $authUserId = Auth::user()->id;
        $userDetails = User::where([['id',$userId],['status',1]])->get()->first();
        $authUserDetails = User::where([['id',$authUserId],['status',1]])->get()->first();
        if(!empty($userDetails) && !empty($authUserDetails)){
            $blockData = UserBlock::where([['blocked_user_id',$authUserId],['blocked_by',$userId]])->orWhere([['blocked_by',$authUserId],['blocked_user_id',$userId]])->get()->toArray();
            if(!empty($blockData)){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
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


    public function chkUserJobAppliedStatus($postId){
        $jobId = $postId;
        $userId = Auth::user()->id;
        $post = JobApplied::where([['job_id',$jobId],['user_id',$userId],['applied_status',2]])->get()->first();
        if(!empty($post)){
            return 0;
        }else{
            return 1;
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
        $status = $this->reportedPostRepository->deleteByCondition([['type_id',$id],['type','=','post_comment']]);   
        
        if($status){
            $response = $commentDetails['type_id'];
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
    }

    public function chkAlertSetting($search){
        if((isset($search['company'])) && ($search['company'] == 2)){
            $alertHistory = [];
            $alertHistory['user_id'] = Auth::user()->id;
            $alertHistory['type'] = 2;
            if(isset($search['company_name']) && $search['company_name'] != ''){
                $alertHistory['keyword'] = ucwords($search['company_name']);
            }
            //$alertHistory['country_id'] = $search['country_id_search_company'];
            if(isset($search['state_comp'])){
                $alertHistory['state_id'] = $search['state_comp'];
            }
            if(isset($search['city_comp'])){
                $alertHistory['city'] = $search['city_comp'];
            }
            $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
            if(($chkExist != null) && ($chkExist->count() > 0)){
                return 1;  
            }else{
                return 0;  
            }
            
            
        }else if((isset($search['company'])) && ($search['company'] == 1)){
            if(isset($search['position_name'])){
                foreach($search['position_name'] as $key=>$val){
                    $alertHistory = [];
                    $alertHistory['user_id'] = Auth::user()->id;
                    $alertHistory['type'] = 1;
                    $alertHistory['keyword'] = ucwords($val);
                    //$alertHistory['country_id'] = $search['country_id'];
                    if(isset($search['state'])){
                        $alertHistory['state_id'] = $search['state'];
                    }
                    if(isset($search['job_id'])){
                        $alertHistory['job_id'] = $search['job_id'];
                    }
                    if(isset($search['city'])){
                        $alertHistory['city'] = $search['city'];
                    }
                    $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                    if(($chkExist != null) && ($chkExist->count() > 0)){
                        return 1;  
                    }else{
                        return 0; 
                    }
                    
                }
                
            }else if(isset($search['job_id'])){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['job_id'] = $search['job_id'];
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    return 1;  
                }else{
                    return 0; 
                }
            }else if(isset($search['state'])){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['state_id'] = $search['state'];
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    return 1;  
                }else{
                    return 0; 
                }
            }
            else if(isset($search['city'])){
                $alertHistory = [];
                $alertHistory['user_id'] = Auth::user()->id;
                $alertHistory['type'] = 1;
                $alertHistory['city'] = $search['city'];
                $chkExist = $this->userJobAlertHistory->findSingleRow($alertHistory);
                if(($chkExist != null) && ($chkExist->count() > 0)){
                    return 1;  
                }else{
                    return 0; 
                }
            }
            //return $result;
            
        }
    }

    public function advertisement(){
        //$data = Advertisements::where('status',1)->orderBy("id","DESC")->take(2)->get()->toArray();
        $data = Advertisements::where('status',1)->orderBy("id","DESC")->get()->toArray();
        return $data;
    }

    public function applyJobDiscardInfo($request){
        $applyId = $request['applied_id'];
        $userId = Auth::user()->id;
        //apply tbl
        $row = JobApplied::where('id', $applyId)->first();
        $jobId = $row['job_id'];
       
        //answer video
        $cond['job_applied_id'] = $applyId;
        $cond['type'] = 2;
        $chkExistData = $this->userJobAppliedAnswers->getAll($cond)->toArray();
        //Video delete from upload tbl
        if(!empty($chkExistData)){
            foreach($chkExistData as $key=>$value){
                $condition [] = ['user_id','=',$userId];
                $condition [] = ['type_id','=',$value['id']];
                $condition [] = ['type','=','user_interview_video'];
                $uploadInfo = $this->uploadRepository->findSingleRow($condition);
                if($uploadInfo){             
                    $this->uploadRepository->deleteWhere($condition);
                    if(Storage::disk('s3')->exists('/'.$uploadInfo->name)){
                        Storage::disk('s3')->delete('/'.$uploadInfo->name);
                    }
                }
            }
            
        }
        //Delete applied answer with video ans
        $deleteAns['job_applied_id'] = $applyId;
        $chkExistData = $this->userJobAppliedAnswers->getAll($deleteAns)->toArray();
        if(!empty($chkExistData)){
            $this->userJobAppliedAnswers->deleteWhere($deleteAns);
        }
        
        //Video delete from Attemp tbl
        $attempt [] = ['user_id','=',$userId];
        $attempt [] = ['job_id','=',$jobId];
       
        $chkExistData4 = $this->userInterviewAttempt->getAll($attempt);
        if(!empty($chkExistData4)){
            foreach($chkExistData4 as $key=>$val){
                $ansTblId = $val['id'];
                $this->userInterviewAttempt->delete($ansTblId);
                if(Storage::disk('s3')->exists('/'.$val->filename)){
                    Storage::disk('s3')->delete('/'.$val->filename);
                }
            }
            
        }
        //info tbl
        $row1 = CandidateJobApplyInfo::where([['job_applied_id','=',$applyId],['user_id','=',$userId]])->first();
        //dd($row1);
        if ($row1) {
            $row1->delete($row1['id']);
        } 
        //apply tbl
        $appliedDelete = JobApplied::where('id', $applyId)->delete();
        return 1;
    }

    public function changeHighlightStatus($candidateId,$val)
    {
        try {
            $user = User::find($candidateId);
            $user->highlight_cv = $val;
            $user->save();
            
        } catch (\Throwable $th) {
            return false;
        }
        return $user;
        
    }

    public function getAllCandidatesWithHighlightCV()
    {
        try {
            $user = User::where('user_type',2)->where('highlight_cv',1)->where('is_payment_done','!=',0)->get();        
        } catch (\Throwable $th) {
            return false;
        }
        return $user;
    }

    public function getAllCandidatesWithoutHighlightCV()
    {
        try {
            $user = User::where('user_type',2)->where('highlight_cv',0)->where('is_payment_done','!=',0)->get();        
        } catch (\Throwable $th) {
            return false;
        }
        return $user;
    }
}