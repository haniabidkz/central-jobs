<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\PostService;
use App\Service\MessageService;
use App\Service\Candidate\CandidateService;
use App\Http\Model\User;
use Session;
use Auth;
use View;

class PostController extends Controller
{
     protected $postService;
     protected $messageService;
     protected $candidateService;
    public function __construct(PostService $postService,MessageService $messageService,CandidateService $candidateService)
    {          
        $this->middleware('isCmpnyCandLoggedIn', ['except' => array('activeYourAccount')]);
        $this->postService = $postService;
        $this->messageService = $messageService;
        $this->candidateService = $candidateService; 
    }

    public function storeTextPost(Request $request)
    {   
    	$request->session()->flash('success-msg', __('messages.YOUR_TEXT_IS_POSTED_SUCCESSFULLY'));
    	$this->postService->storeTextPost($request);  
    	return redirect()->back();  	
    }
    public function storeImagePost(Request $request)
    {       	    	
    	$request->session()->flash('success-msg', __('messages.YOUR_IMAGE_IS_POSTED_SUCCESSFULLY'));
    	$this->postService->storeImageVideoPost($request);  
    	return redirect()->back();  	
    }
    public function storeVideoPost(Request $request)
    {       	       		
    	$request->session()->flash('success-msg', __('messages.YOUR_VIDEO_IS_POSTED_SUCCESSFULLY'));
    	$this->postService->storeImageVideoPost($request,'video');  
    	return redirect()->back();  	
    }
    public function storeAnyPost(Request $request)
    {       	       		
    	$request->session()->flash('success-msg', __('messages.YOU_HAVE_CREATED_A_POSTED_SUCCESSFULLY'));
    	$this->postService->storeAnyTypePost($request);  
    	return redirect()->back();  	
    }
    
    /**
    * Function to list user post comment
    * @return json $response
    */
    public function postLike(Request $request)
    {
         $response =  $this->postService->postLike($request);
         return $response;
    }

    /**
    * Function to list user post comment
    * @return json $response
    */
    public function postComment(Request $request)
    {
         $response =  $this->postService->postComment($request);
         return $response;
    }

    /**
    * Function to list user post comment
    * @return json $response
    */
    public function reportPost(Request $request)
    {
         $response =  $this->postService->reportPost($request);
         return $response;
    }

    /**
    * Function to connection request to candidate
    * @return json $response
    */
    public function sendConnectionRequest(Request $request)
    {
         $response =  $this->postService->sendConnectionRequest($request);
         return $response;
    }
    /**
    * Function to connection request to candidate
    * @return json $response
    */
    public function acceptRejectConnection(Request $request)
    {
         $response =  $this->postService->acceptRejectConnection($request);
         return $response;
    }
    /**
    * Function to list user post comment
    * @return json $response
    */
    public function postShare(Request $request)
    {
         $chk = $this->postService->chkPostShare($request);
         if($chk != null){
            $request->session()->flash('success-msg', __('messages.SORRY_YOUR_POST_ALREADY_BEEN_SHARED'));
         }else{
            $request->session()->flash('success-msg', __('messages.YOUR_SHARE_IS_POSTED_SUCCESSFULLY'));
            $response =  $this->postService->postShare($request);
         }
         if((Auth::user()) && (Auth::user()->user_type == 2)){
          return redirect('candidate/dashboard');
         }else if((Auth::user()) && (Auth::user()->user_type == 3)){
          return redirect('company/dashboard');
         }
         
    }

    /**
    * Function to block user
    * @return json $response
    */
    public function blockUnblockUser(Request $request)
    {
         $response =  $this->postService->blockUnblockUser($request);
         return $response;
    }

     /**
     * Developer : Israfil
     * Function to show Dashboard
     *
     */ 
    public function postShareData(Request $request)
    {   
        $id = $request['post_id'];
        $postRow = $this->postService->getPostDetails($id); 
        if($postRow != ''){
          $view = view('frontend.post.shareData',compact('postRow'))->render();
          return response()->json(['html'=>$view]);
        } else{
          return 1;
        }
        
    }

    public function chkUserStatus(Request $request){
      $user = $request['user_id'];
      $chkUserStatus = $this->postService->chkUserStatus($user);
      return $chkUserStatus;
    }

    public function chkUserStatusJob(Request $request){
      $postId = $request['job_id'];
      $chkUserStatus = $this->postService->chkUserPostStatus($postId);
      return $chkUserStatus;
    }


   /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 05/05/2020
    @FunctionFor: Candidate manage profile.
    @return : view
    */
    public function activeYourAccount(Request $request,$id)
    {
        //dd(base64_decode($id));
        
        $request['email'] = base64_decode($id);
        $userDetails = User::where('email', $request['email'])->get()->first();
        $request['id'] = $userDetails['id'];
        $request['acc'] = 1;
        $profileData = $this->candidateService->updateUserStatus($request->all());
        if($profileData){
          $request->session()->flash('status', __('messages.YOUR_ACCOUNT_IS_SUCCESSFULLY_ACTIVATED'));
           return redirect('/');
        }
    }

    public function chkUserJobAppliedStatus(Request $request){
      $chkUserStatus = $this->postService->chkUserJobAppliedStatus($request);
      return $chkUserStatus;
    }


    /**
    * Function to store session check and active user check
    * @return json $response
    */
   public function chkSessionUserStatus(Request $request)
   {
     
    try{
          $user = Auth::user();
          if($user){
               $userId = $user->id;
               $userChk = $this->postService->chkUserStatus($userId);
               if($userChk == 0){
                    $message = __('messages.SORRY_SOMETHING_WENT_WRONG');
                    $staus = 0;
                    $response = [];
               }else{
                    $response = [];
                    $message = 'ok';
                    $staus = 200;
               }
          }else{
               $message = __('messages.SORRY_SOMETHING_WENT_WRONG');
               $staus = 0;
               $response = [];
          }
          
     }catch(\Exception $e){
           $message = $e->getMessage();
           $staus = 400;
           $response = [];
     }

     return response()->json(['success' => $staus, 'message' => $message ,'intro_info' => $response]);
   }

    

}
