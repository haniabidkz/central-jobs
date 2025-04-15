<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Service\CmsService;
use App\Service\Candidate\CandidateService;
use App\Service\BestAdvertisementService;
use App\Service\StateService;
use App\Http\Model\State;
use App\Http\Model\City;
use DB;
use Newsletter;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $cmsServices; 
    protected $candidateService;
    protected $stateService;
    protected $bestAdvertisementService;
    public function __construct(
        CmsService $cmsService,
        CandidateService $candidateService,
        StateService $stateService,
        BestAdvertisementService $bestAdvertisementService
    )
    {
        //$this->middleware('auth');
        $this->cmsServices = $cmsService;
        $this->candidateService = $candidateService;
        $this->stateService = $stateService;
        $this->bestAdvertisementService = $bestAdvertisementService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        if(Auth::check() && Auth::user()->user_type == 1){
            // if(Auth::user()->user_type == 3){ // company
            //     return redirect('/company/dashboard');
            // }
            if(Auth::user()->user_type == 1){ // admin
                return redirect('/admin/dashboard');
            }
            
        }else{
            $data = [];
            $data['id'] = $id = 6;
            $data['data'] = $this->cmsServices->getCmsDataForHome($id);
            $data['position'] = $this->candidateService->positionFor();
            $selectedCountry = 14;
            $selectedCountry1 = 14;
            $data['states'] = $states = $this->stateService->getStateById($selectedCountry);
            $data['states1'] = $states1 = $this->stateService->getStateById($selectedCountry1);
            foreach($states as $key => $state)
            {
                $stateIds [] = $state->id;
            }
            $stateIds = array_filter(array_unique($stateIds));
            $cities = $this->stateService->getAllSelectedCity($stateIds);
            $data['best_advertise'] = $this->bestAdvertisementService->getBestAdvertise();
            $data['cities'] = $cities;
      
            return view('home', $data);
        }
        
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        
        if(Auth::check()){
            if(Auth::user()->user_type == 2){ // candidate
                return redirect('/candidate/dashboard');
            }
            if(Auth::user()->user_type == 3){ // company
                return redirect('/company/dashboard');
            }
            if(Auth::user()->user_type == 1){ // admin
                return redirect('/admin/dashboard');
            }
            
        }else{
            $id = 6;
            $data = $this->cmsServices->getCmsDataForHome($id);
            return view('login',compact('id','data'));
        }
        
    }
    public function emailVerification($id)
    {
        $pageTitle = "Email verification require";
        return view('frontend.home.emailVerificationRequire',compact('pageTitle'));
    }
    public function pendingAdminVerification($id)
    {
        $pageTitle = "Pending Admin Approval";
        return view('frontend.home.pendingAdminApproval',compact('pageTitle'));
    }
    public function blockedByAdmin(Request $request,$id)
    {
        $request->session()->invalidate();
        $pageTitle = "Blocked by admin";
        return view('frontend.home.blockedByAdmin',compact('pageTitle'));
    }
    public function getDetails(Request $request){
        $email = $request['email'];
        $data = User::where([['email',base64_encode($email)]])->first();
        echo json_encode($data);
    }
    public function rejectedAdminVerification($id){
        $pageTitle = "Rejected Admin Approval";
        return view('frontend.home.rejectedAdminApproval',compact('pageTitle'));
    }
    public function activateUser(Request $request,$id)
    {
        //dd(base64_decode($id));
        $request->session()->invalidate();
        $pageTitle = "Activate User";
        return view('frontend.home.activateUser',compact('pageTitle','id'));
    }
    // public function newsletter(Request $request){
    //     $email = $request['email'];
    //     Newsletter::subscribe($email);
    //     request()->session()->flash('success-msg', __('messages.YOUR_EMAIL_SUBSCRIBED_SUCCESSFULLY') );
    //     return redirect()->back();
    // }

    public function companySignup(){
    
        $id = 6;
        $data = $this->cmsServices->getCmsDataForHome($id);
        return view('companySignup',compact('id','data'));
    }
}
