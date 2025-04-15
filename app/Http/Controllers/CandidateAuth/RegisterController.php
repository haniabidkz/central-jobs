<?php

namespace App\Http\Controllers\CandidateAuth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailVerifyLinkSent;
use App\Mail\WelcomeEmailSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\Profile;
use App\Service\Candidate\CandidateService;
use App\Service\CmsService;
use Newsletter;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * candidate service to create slug.
     *
     * @var string
     */
    protected $candidateService;
    protected $cmsServices;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CandidateService $candidateService,CmsService $cmsService)
    {
        $this->middleware('guest');
        $this->candidateService = $candidateService;
        $this->cmsServices = $cmsService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_conditions_status' => ['required']
        ]);
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if((isset($data['is_newsletter_subscribed'])) && $data['is_newsletter_subscribed'] == "on"){
            $data['is_newsletter_subscribed'] = 1;
        }else{
            $data['is_newsletter_subscribed'] = 0;
        }
        if($data['privacy_policy_status'] == "on"){
            $data['privacy_policy_status'] = 1;
        }
        if((isset($data['cookies_policy_status'])) &&  $data['cookies_policy_status'] == "on"){
            $data['cookies_policy_status'] = 1;
        }
        $terms_conditions_status = 0;
        if($data['terms_conditions_status'] == "on"){
            $data['terms_conditions_status'] = 1;
        }
        if($data['user_type'] == 2){//candidate
           return $this->insertCandidateData($data);
        }else{
            return false;
        }
    }
    
    /**
     * Function to insert info for company
     * @param array $data
     * return mix
     */
    public function insertCandidateData($data)
    {
        $slug = $this->candidateService->getUniqueSlug($data['first_name']);
        $insertData = User::create([
            'first_name' => $data['first_name'],
            'slug' => $slug,
            'email' => $data['email'],
            'user_type' => $data['user_type'],            
            'password' => Hash::make($data['password']),
            'country_id' => 30,
            'is_newsletter_subscribed' => $data['is_newsletter_subscribed'],
            'terms_conditions_status' => $data['terms_conditions_status'],
            'privacy_policy_status' => $data['privacy_policy_status'],
            'cookies_policy_status' => 0
        ]);
        if($insertData){
            $userId = $insertData->id;
            $profile = Profile::create([
            'user_id' => $userId,
            'approve_status' => 0
            ]);
            if($data['is_newsletter_subscribed'] == 1){
                $email = $data['email'];
                Newsletter::subscribe($email);
            }
            
            $this->sentEmailVarificationLink($data['email']);
        }
        return $insertData;
    }
    
    /**
     * Function to sent email varification link to user's email
     * @param arrray $data
     * @param int $userId
     * @return mix
     */
    public function sentEmailVarificationLink($email){
        $data = User::where([['email',base64_encode($email)]])->first();
       
        if($data != null){
            $data = $data->toArray();
        }else{
            request()->session()->flash('status', "Something went wrong!");
            return redirect('home');
        }
        $emailVerifyToken = microtime();
        $encryptEmailVerifyToken =  encrypt($emailVerifyToken);
        $data['email_verify_token'] = $encryptEmailVerifyToken;
        $update = [];
        $update['email_verify_token'] = $encryptEmailVerifyToken;
        $update['email_verify_token_created'] = date('Y-m-d H:i'); //Fomat Date and time;
        User::where([['id',$data['id']]])
            ->update($update);
        $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
        $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
        $data['imgPath'] = $imgPath;
        $data['logoPath'] = $logoPath;
        
        try {
            Mail::to($email)->send(new EmailVerifyLinkSent($data));
        } catch (Exception $ex) {
            // Debug via $ex->getMessage();
            //return "We've got errors!";
        }
        if($data['user_type'] == 3){
            $regSuccessMsg = '';
            $title = '';
            $id = 6;
            $data = $this->cmsServices->getCmsDataForHome($id);
            
            if(isset($data[2]['text'])){
                $regSuccessMsg = $data[2]['text'];
                $title = $data[4]['text'];
            }
            $this->redirectTo = '/joinus';
            //echo 1; exit;
            return redirect('joinus')->with( ['regSuccessMsg' => $regSuccessMsg,'title' => $title] );
           
        }else{
            request()->session()->flash('status', __('messages.EMAIL_VERIFICATION_LINK_HAS_BEEN_SENT_TO_YOUR_REGISTERED_EMAIL'));
            return redirect('home');
        }
        
    }

    /**
     * Verify the email and activate the account
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function activate($token)
    {
        $user = User::where('email_token', $token)->first();
        if(empty($user))
        {
            return redirect('/')->withErrors(['token_missmatch' => 'Token is invalid']);
        }
        else
        {
            if($user->status == 'Active')
            {
                return redirect()->route('user.login')->with(['status' => 'Alreday activated your account. Please Login.']);
            }
            elseif($user->status == 'Inactive' && $user->email_verified_at == NULL)
            {
                $user->status = 'Active';
                $user->email_verified_at = now();
                $user->save();

                return redirect()->route('user.login')->with(['status' => 'You have activate your account successfully. Please Login.']);
            }
            else
            {
                return redirect('/')->withErrors(['token_missmatch' => 'Token is invalid or user has expired.']);
            }
        }
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
