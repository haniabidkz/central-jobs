<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Company\CompanyService;
use App\Service\Candidate\CandidateService;
use App\Service\CountryService;
use App\Service\StateService;
use App\Service\UploadService;
use App\Service\CommonService;
use App\Service\JobService;
use App\Service\PaymentService;
use Auth;
use View;
use App\Service\PostService;
use App\Service\MessageService;
use DB;

class Company extends Controller
{
    protected $companyService;
    protected $uploadService;
    protected $countryService;
    protected $stateService;
    protected $candidateService;
    protected $commonService;
    protected $jobService;
    protected $postService;
    protected $messageService;
    protected $paymentService; 

    public function __construct(CompanyService $companyService,
        CountryService $countryService,
        UploadService  $uploadService,
        StateService $stateService,
        CandidateService $candidateService,
        CommonService $commonService,
        JobService $jobService,
        PostService $postService,
        MessageService $messageService,
        PaymentService $paymentService
    )
    {   
        
        $this->middleware('companyAuth', ['except' => array('publicProfile','activeYourAccount','checkUniqueEmail')]);
        $this->companyService = $companyService;
        $this->countryService = $countryService;
        $this->uploadService = $uploadService;
        $this->stateService = $stateService;
        $this->candidateService = $candidateService;
        $this->commonService = $commonService;
        $this->jobService = $jobService;
        $this->postService = $postService;
        $this->messageService = $messageService;
        $this->paymentService   = $paymentService;
    }
    /**
     * Developer : Israfil
     * Function to show Dashboard
     *
     */ 
    public function dashboard()
    {
        $activeClass = 'dashboard';
        $postData = $this->companyService->getPostList(Auth::user()->id); 
       
        $user_type_id = 3;
        $user_type = 'company'; 
        return view('frontend.candidate.dashboard',compact('postData','user_type','user_type_id','activeClass'));
    }

    /**
     * Developer : Rumpa Ghosh 
     * Function to list all followers
     * @return string view
     */
    public function viewFollowers(){
        $allFollowers = $this->companyService->getFollowersList(Auth::user()->id);
        $pageTitle = 'View Followers';
        $metaTitle = "View Followers";
        return view('frontend.company.viewFollowers',compact("pageTitle","metaTitle","allFollowers"));
    }


    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 05/05/2020
    @FunctionFor: company public profile.
    @return : view
    */
    public function publicProfile(Request $request,$slug){

        $pageTitle = 'View Profile';
        $metaTitle = "View profile";
        $profileData = $this->companyService->getDetailsBySlug($slug);
        $allFollowers = $this->companyService->getFollowers($profileData['id'])->count();
        $isReported = $this->companyService->isReported($profileData['id']);
        //dd($isReported);
        if(Auth::user()){
            $user_type_id = Auth::user()->user_type;
        }else{
            $user_type_id = 3;
        }
        
        if($user_type_id == 3){
            $user_type = 'company';
        }else if($user_type_id == 2){
            $user_type = 'candidate';
        }else{
            $user_type = 'company';
        }
        $search = $request->all();
        if(empty($search)){
            $search['page'] = 1;
        }
        $postData = $this->companyService->getPostList($profileData['id'],$search); 
        if ($request->ajax()) {
            $view = view('frontend.company.postData',compact("pageTitle","metaTitle","profileData",'allFollowers','postData','user_type_id','search','user_type','isReported'))->render();
            return response()->json(['html'=>$view]);
        }
        
        //$user_type = 'company';
        
        return view('frontend.company.view',compact("pageTitle","metaTitle","profileData",'allFollowers','postData','user_type_id','search','user_type','isReported'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 05/05/2020
    @FunctionFor: Company manage profile.
    @return : view
    */
    public function manageProfile(){
        $pageTitle = 'Manage Profile';
        $metaTitle = "Manage profile";
        return view('frontend.company.manageProfile',compact("pageTitle","metaTitle"));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 05/05/2020
    @FunctionFor: Candidate manage profile.
    @return : view
    */
    public function manageProfilePost(Request $request){
        $profileData = $this->companyService->updateUserStatus($request->all());
        if($profileData){
            request()->session()->flash('success-msg', __('messages.YOUR_PROFILE_DELETED_SUCCESSFULLY') ); 
            Auth::logout();
            return redirect('/');
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/04/2020
    @FunctionFor: Company profile view and edit.
    @param : int $userId
    @return : string view
    */
    public function editProfile(){
        $profileData = $this->companyService->getDetails(Auth::user()->id);
        //$profileData['country_id'] = 14; // Austria
        $countries = $this->countryService->findAllCountryListWithStates();
        $allFollowers = $this->companyService->getFollowers(Auth::user()->id)->count();
        $allFollowersList = $this->companyService->getFollowersList(Auth::user()->id);
        $imageLibrary = $this->candidateService->getMyhrImageLibrary();
        $pageTitle = 'Edit Profile';
        $metaTitle = "Edit profile";
        return view('frontend.company.edit',compact("pageTitle","metaTitle","allFollowers","profileData","countries","imageLibrary","allFollowersList"));
    }
    /**
     * Function to upload banner image
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadBannerImage(Request $request)
    {
        $response = $this->companyService->uploadBannerImage($request);       
        echo json_encode($response);
    }

    /**
     * Function to upload profile image
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function uploadProfileImg(Request $request)
    {
        $response = $this->companyService->uploadProfileImage($request);       
        echo json_encode($response);
    }
    /**
    * Function to get country list 
    * @param integer $id
    * @return json $states
    */
   public function getCountryStates($id)
   {       
        $states = $this->countryService->getStatesByCountry($id);
        echo json_encode($states);
   }
   /**
    * Function to store candidate profile info
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
   public function storeProfileInfo(Request $request)
   {
      $response = $this->companyService->storeProfileInfo($request);
      echo json_encode($response);
   }

   /**
    * Function to remove banner image
    * @return json $response
    */
   public function removeProfileImg()
   {
        $response =  $this->uploadService->deleteProfileImg();
        echo json_encode($response);
   }
   /**
    * Function to remove banner image
    * @return json $response
    */
   public function removeBannerImg()
   {
        $response =  $this->uploadService->deleteBannerImg();
        echo json_encode($response);
   }
   /**
    * Search for candidates with critarea
    * @param Illuminate\Http\Request $request
    * @return View
    */
   public function findCandidates(Request $request)
   {    
        $activeClass = 'candidate';
        $search = $request->all();
        if(empty($search)){
            $search['page'] = 1;
            $search['country_id'] = 14;
            $states = $this->stateService->getStateById(14); // Austria country id 14
        }
        else if(isset($search['country_id']) && $search['country_id'] != ''){
            $states = $this->stateService->getStateById($search['country_id']);
        }else{
            $search['country_id'] = 14;
            $states = $this->stateService->getStateById(14); // Austria country id 14
        }
        $countries = $this->countryService->getCountryList();
        $language = $this->candidateService->getLanguageArr();
        $allProfileHeadline = $this->candidateService->getProfileHeadLines();
        //dd($allProfileHeadline);
        $searchResult = $this->companyService->findCandidates($search);
        
        //return $searchResult;
        $pageTitle = 'Find Candidates';
        $metaTitle = "Find Candidates";
        if ($request->ajax()) {
            $count = count($searchResult);
            if($count == 0 && !isset($search['flag'])){
                return 0;
            }else{
                $view = view('frontend.company.data',compact("pageTitle","metaTitle","states","countries","search","language","searchResult","allProfileHeadline"))->render();
                return response()->json(['html'=>$view]);
            }
            
        }
        return view('frontend.company.findcandidate',compact("pageTitle","metaTitle","states","countries","search","language","searchResult","allProfileHeadline","activeClass"));
   }
   /**
    * Search for candidates with critarea
    * @param Illuminate\Http\Request $request
    * @return View
    */
   public function checkUniqueCompany(Request $request){
        $response =  $this->companyService->checkUniqueCompany($request);
        echo json_encode($response);
   }
   /**
    * @DevelopedBy: Rumpa Ghosh
    * @Date: 20/02/2020
    * @FunctionFor: get state list
    */
    public function getState(Request $request){
        if($request->ajax()){
            $countryId = $request->input('id');
            $states = $this->stateService->getStateById($countryId);
            $view = View::make('frontend.company.states', [
                'states'=> $states
            ]);
            $html = $view->render();
            return $html;
        }
    }
    /**
    * Function to remove user post
    * @return json $response
    */
   public function deleteUserPost(Request $request)
   {
        $response =  $this->companyService->deleteUserPost($request);
        echo json_encode($response);
   }
   /**
    * Function to list user post comment
    * @return json $response
    */
    public function listUserPostComment(Request $request)
    {
         $response =  $this->companyService->listUserPostComment($request);
         return $response;
    }
    /**
    * Function to list user post comment
    * @return json $response
    */
    public function reportComment(Request $request)
    {
         $response =  $this->companyService->reportComment($request);
         return $response;
    }
    /**
     * Developer : Rumpa
     * Function to post job
     *
     */ 
    public function postJob($id="")
    {
        $id=base64_encode(0);
        $pageTitle = 'Post Job';
        $metaTitle = "Post Job";
        $selectedCountry = 14; // Austria country id 14
        $countries = $this->countryService->getCountryList();
        $states = $this->stateService->getStateById($selectedCountry); // Austria country id 14
        foreach($states as $key => $state)
        {
            $stateIds [] = $state->id;
        }
        $stateIds = array_filter(array_unique($stateIds));
        $cities = $this->stateService->getAllSelectedCity($stateIds);
        $seniority = $this->companyService->getSeniorityList();
        $employment = $this->companyService->getEmploymentList();
        $language = $this->companyService->getLanguageList();
        $itSkill = $this->candidateService->getSkillArr();
        return view('frontend.company.jobPost',compact('id','pageTitle','metaTitle','countries','selectedCountry','states','cities','seniority','employment','language','itSkill'));
    }
    /**
     * Developer : Rumpa
     * Function to post job
     *
     */ 
    public function postJobPost(Request $request)
    {
        $employment = $this->companyService->postJobPost($request);
        $postID=$employment->id;
        request()->session()->flash('success-msg', __('messages.JOB_CREATED_SUCCESSFULLY') );
        $plans = $this->paymentService->getPaymentValue();
        return view('frontend.company.jobAdvertisement',compact('plans','postID'));
       // return redirect('/company/my-jobs');
    }

    public function uploadJobDescImage(Request $request){
        $postDescImage = $this->companyService->uploadJobDescImage($request);
    }

    /**
     * Developer : Rumpa
     * Function to list job
     *
     */ 
    public function jobList(Request $request)
    {
        $search = $request->all();
        //dd($request->city);
        $selectedCountry = 14; // Austria country id 14
        $countries = $this->countryService->getCountryList();
        $states = $this->stateService->getStateById($selectedCountry); // Austria country id 14
        
        if($request->state){
            $stateIds [] = $request->state;
        }else{
            foreach($states as $key => $state)
            {
                $stateIds [] = $state->id;
            }
        } 
        
        $stateIds = array_filter(array_unique($stateIds));
        $cities = $this->stateService->getAllSelectedCity($stateIds);
       
        if($request->city != null)
        {
            $city = $this->stateService->getCityDetailsId($request->city);
            $request->merge( ['citySearch' => $city->name]);
        }
        $jobList = $this->companyService->jobList($request);
        
        $company = Auth::user()->company_name; 
        $pageTitle = 'My Jobs';
        $metaTitle = "My Jobs";
        return view('frontend.company.jobList',compact('pageTitle','metaTitle','jobList','company','selectedCountry','countries','states','search','cities'));
    }

    public function cityByState(Request $request){
        $cities = $this->stateService->getAllSelectedCity(array($request->id));
        return json_encode($cities->toArray());
    }

    /**
     * Developer : Rumpa
     * Function to list job
     *
     */ 
    public function jobDetails(Request $request)
    {
        $firstJobArr = $this->companyService->jobDetails($request);
        $company = Auth::user()->company_name; 
        $view = View::make('frontend.company.jobDetails', [
            'firstJobArr'=> $firstJobArr,
            'company'=> $company
        ]);
        $html = $view->render();
        return $html;
    }

    /**
    * Search for candidates with critarea
    * @param Illuminate\Http\Request $request
    * @return View
    */
   public function appliedCandidates($id,Request $request)
   {    
        $search = $request->all();
        $search['id'] = decrypt($id);
        if(isset($search['country_id']) && $search['country_id'] != ''){
            $states = $this->stateService->getStateById($search['country_id']);
        }else{
            $states = [];
        }
        if(isset($search['state_id']) && $search['state_id'] != ''){
            $cities = $this->stateService->getCityById($search['state_id']);
        }else{
            $cities = [];
        }
        //$city = $this->stateService->getAllCity();
        $countries = $this->countryService->getCountryList();
        $language = $this->candidateService->getLanguageArr();
        $searchResult = $this->companyService->appliedCandidates($search);
        //return $searchResult;
        $pageTitle = 'Applied Candidates';
        $metaTitle = "Applied Candidates";
        
        return view('frontend.company.appliedCandidate',compact("pageTitle","metaTitle","states","cities","countries","search","language","searchResult"));
   }

   /**
     * Developer : Rumpa Ghosh 
     * Function to list all followers
     * @return string view
     */
    public function myNetwork(Request $request,$msgId='')
    {
        $activeClass = 'myNetwork';
        if($msgId != ''){
            $msgId = decrypt($msgId);
            $changeSeenStatus = $this->commonService->changeStatus($msgId);
        }
        $search = $request->all();
        $connectedList = $this->companyService->candidateConnectedList($search);
        $pageTitle = 'My Network';
        $metaTitle = "My Network";
        return view('frontend.company.myNetwork',compact("pageTitle","metaTitle","connectedList",'search','activeClass'));
    }

    /**
     * Developer : Rumpa
     * Function to post job
     *
     */ 
    public function editJob(Request $request,$id='')
    {
        $jobId = decrypt($id);
        $details = $this->jobService->details($jobId);
        $pageTitle = 'Edit Job';
        $metaTitle = "Edit Job";
        $selectedCountry = $details['country']['id']; // Austria country id 14
        $countries = $this->countryService->getCountryList();
        $states = $this->stateService->getStateById($selectedCountry); // Austria country id 14
        if($details['postState'] != null){
            $stateArr = [];
            foreach($details['postState'] as $key=>$val){
                array_push($stateArr,$val['state_id']);
            }
            $allCity = $this->stateService->getAllSelectedCity($stateArr);
        }
        $selectedCity = explode(",",$details['city']);
        $seniority = $this->companyService->getSeniorityList();
        $employment = $this->companyService->getEmploymentList();
        $language = $this->companyService->getLanguageList();
        $itSkill = $this->candidateService->getSkillArr();
        return view('frontend.company.jobEdit',compact('pageTitle','metaTitle','countries','selectedCountry','states','seniority','employment','language','itSkill','details','allCity','selectedCity'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 17/03/2020
    @FunctionFor: Job edit post
    */
    public function editJobPost(Request $request,$id=''){
        $id = decrypt($id);
        $this->jobService->updateDetails($id,$request->all());
        request()->session()->flash('success-msg', __('messages.JOB_UPDATED_SUCCESSFULLY') );
        return redirect('/company/my-jobs');
    }
    
    /**
     * 
     */
    public function deleteJob(Request $request, $id)
    {
        $id = decrypt($id);
        $response = $this->jobService->deleteJob($id);
        $message = __('messages.JOB_DELETED_SUCCESSFULLY');
        $staus = 0;
        return response()->json(['success' => $staus, 'message' => $message ,'intro_info' => $response]);
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 05/05/2020
    @FunctionFor: Candidate manage profile.
    @return : view
    */
    // public function activeYourAccount(Request $request)
    // {
    //     dd(decrypt($id));
    //     $request['id'] = decrypt($id);
    //     $request['acc'] = 1;
    //     $profileData = $this->candidateService->updateUserStatus($request->all());
    //     if($profileData){
    //        return redirect('/');
    //     }
    // }
     /**
    * Function to get country list 
    * @param integer $id
    * @return json $states
    */
    public function getStatesCity($id)
    {       
         $city = $this->stateService->getCityById($id);
         echo json_encode($city);
    }

    public function getMultistatesMulticity(Request $request){
        $city = $this->stateService->getCityByIdIn($request);
        echo json_encode($city);
    }

    public function checkUniqueEmail(Request $request){
        $count = $this->companyService->checkUniqueEmail($request->all());
        return $count;
    }

    /**
     * Developer : Israfil
     * Function to show Dashboard
     *
     */ 
    public function viewPost(Request $request,$id,$msgId='')
    {   
         
        if($msgId != ''){
          $msgId = decrypt($msgId);
          $changeSeenStatus = $this->messageService->changeStatus($msgId);
          $getNotification = $this->messageService->getNotificationDetail($msgId);
          if($getNotification == 0){
            $request->session()->flash('success-msg', __('messages.NO_JOB_POST_AVAILABLE'));
            return redirect()->back();  
          }
          
        }
        $id = decrypt($id);
        $postData = $this->postService->getPostDetails($id); 
        if((Auth::user())){
          $user_type_id = Auth::user()->user_type;
        }else{
          $user_type_id = '';
        }
        
        return view('frontend.candidate.viewPost',compact('postData','user_type_id'));
    }
    /**
     * Developer : Israfil
     * Function to show Dashboard
     *
     */ 
    public function viewJobPost(Request $request,$id,$msgId='')
    {   
        if($msgId != ''){
          $msgId = decrypt($msgId);
          $changeSeenStatus = $this->messageService->changeStatus($msgId);
          $getNotification = $this->messageService->getNotificationDetail($msgId);
          if($getNotification == 0){
            $request->session()->flash('success-msg', __('messages.NO_JOB_POST_AVAILABLE'));
            return redirect()->back();  
          }
          
        }
        $id = decrypt($id);
        $postData = $this->postService->getPostDetails($id); 
        if(Auth::user()){
          $user_type_id = Auth::user()->user_type;
        }else{
          $user_type_id = '';
        }
        
        if($user_type_id = 2){
            $user_type = 'candidate';
        }elseif($user_type_id = 3){
            $user_type = 'company';
        }else{
          $user_type = '';
        }
        return view('frontend.candidate.viewJobPost',compact('postData','user_type_id','user_type'));
    }
    /**
    * Function to remove user post comment
    * @return json $response
    */
   public function deleteUserComment(Request $request)
   {
        $response =  $this->companyService->deleteUserComment($request);
        echo json_encode($response);
   }
   /**
    * Function to upload banner image from myHr Library
    * @param Illuminate\Http\Request $request
    * @return json $response
    */
    public function uploadBannerImageFromLibrary(Request $request)
    {
       $response = $this->candidateService->uploadBannerImageFromLibrary($request);
       echo json_encode($response);
    }
}
