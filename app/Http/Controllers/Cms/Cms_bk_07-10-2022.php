<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CmsService;
use App\Service\SubscriptionService;
use Auth;
use App\Mail\ContactUsEmail;
use App\Mail\ContactUsAdminEmail;
use Mail;
use DB;
class Cms extends Controller
{

   protected $cmsServices; 
   protected $subscriptionService;
   public function __construct(CmsService $cmsService,SubscriptionService $subscriptionService)
    {   
        $this->cmsServices = $cmsService;
        $this->subscriptionService = $subscriptionService;
    }
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */ 
    public function contactUs(Request $request)
    {
        if($request->method() == 'POST'){
            $data = $request->all();
            try {
                // dd($data);
                $checkRestriction = $this->cmsServices->checkRestriction();
                if($checkRestriction == 'true'){
                    $request->session()->flash('error-msg', 'You are not allow to send message');
                    return redirect()->back(); 
                }
                $contactUsData = $this->cmsServices->saveContactUsData($data);
                $admin = $this->cmsServices->getAdminData();
                $mailTo = $admin['email'];
                if(($data['subject'] == 'Questions') || ($data['subject'] == 'Suggestions') || ($data['subject'] == 'Others')){
                    $mailTo = 'info@central-jobs.com';
                }else{
                    $mailTo = 'info@central-jobs.com';
                }
                Mail::to($mailTo)->send(new ContactUsAdminEmail($data));
                Mail::to($data['email'])->send(new ContactUsEmail($data));
                $request->session()->flash('success-msg', 'Contact Information successfully submitted');
                return redirect()->back(); 
            } catch (Exception $ex) {
                // Debug via $ex->getMessage();
                //return "We've got errors!";
            }
        }else{
            $id = 3;
            $data = $this->cmsServices->getCmsData($id);
            return view('frontend.cms.contactUs',compact('id','data'));
        }
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function tips()
    {
        $id = 4;
        $data = $this->cmsServices->getCmsData($id);
        return view('frontend.cms.tips',compact('id','data'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */ 
    public function aboutUs()
    {
        $id = 5;
        $data = $this->cmsServices->getCmsData($id);
        
        return view('frontend.cms.aboutUs',compact('id','data'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function homePage()
    {
        $id = 6;
        return view('frontend.cms.homePage',compact('id'));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function privacy()
    {
        $id = 1;
        $data = $this->cmsServices->getCmsData($id);
        return view('frontend.cms.privacy',compact('id','data'));
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function terms()
    {
        $id = 2;
        $data = $this->cmsServices->getCmsData($id);
        return view('frontend.cms.terms',compact('id','data'));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function service()
    {
        $id = 7;
        $data = $this->cmsServices->getCmsData($id);
        $subscriptions = $this->subscriptionService->getActiveSubscriptions();
        $name = '';
        $email = '';
        if(Auth::user()){
            $name = Auth::user()->first_name;
            $email = Auth::user()->email;
        }

        //dd($data);
        return view('frontend.cms.service',compact('id','data','name','email','subscriptions'));
    }

    public function setLanguage(Request $request){
        $return = $this->cmsServices->setLanguage($request);
        echo $return;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function cookiesPolicy()
    {
        $id = 8;
        $data = $this->cmsServices->getCmsData($id);
        return view('frontend.cms.cookies',compact('id','data'));
    }
}
