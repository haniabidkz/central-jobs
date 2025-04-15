<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Service\UserLoginHistoryService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/candidate/dashboard';
    protected $redirectToCompany = '/company/dashboard';
    protected $loginUserHistory;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserLoginHistoryService $loginUserHistory)
    {
        $this->middleware('guest')->except('logout');
        $this->loginUserHistory = $loginUserHistory;
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {   
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) { 
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $email = base64_encode($request->input('email'));
        //check is email verified
        $isEmailVerified = $this->isEmailVerified($request);
        if(!$isEmailVerified){ 
            return redirect('/email-verification-pending/'.$email);
        }
        //check is user blocked
        $isUserActive = $this->isUserActive($request);
        if(!$isUserActive){ 
            return redirect('/blocked-by-admin/'.$email);
        }
        //check if user is company account
        $isCompany = $this->isCompany($request);
        if($isCompany){
            $isProfileActive = $this->getCompanyProfileStatus($request);
            if(!$isProfileActive){                
                return redirect('/pending-admin-approval/'.$email);
            }
        }
        
        //check if user is company account
        if($isCompany){
            $isProfileRejected = $this->getCompanyProfileRejectStatus($request);
            if(!$isProfileRejected){                
                return redirect('/rejected-admin-approval/'.$email);
            }
        }
       
        if ($this->attemptLogin($request)) { 
            //check is user Paid
            $isUserPaid = $this->isUserPaid($request);
            if(!$isUserPaid){
                return redirect('/payments/');
            }
            //check if user is candidate account screening question
            /* $isCandidate = $this->isCandidate($request);
            if($isCandidate){
                $isMcqComplete = $this->getCandidateProfileStatus($request);
                if(!$isMcqComplete){                
                    return redirect('candidate/screening-mcq/');
                }
            } */
            
            return $this->sendLoginResponse($request);
        }  
	
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
	
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $request->merge([
            'email' => base64_encode($request->email),
        ]);
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    /**
     * Get the user information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getUserInfo(Request $request)
    { 
        $userInfo = DB::table('users')
                    ->join('profiles','users.id', '=', 'profiles.user_id')
                    ->where('users.email',base64_encode($request->input('email')))
                    ->where('users.deleted_at',NULL)
                    ->where('users.user_type','!=',1)
                    ->first();
        if (($userInfo != '') && Hash::check($request->input('password'), $userInfo->password)) {
            return $userInfo;
        } else{
            return $this->sendFailedLoginResponse($request);
        }           
        
        
    }
    /**
     * Function to check email verification pending status
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    protected function isEmailVerified(Request $request)
    {
        $isEmailVerified = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $isEmailVerified = true;
        }
        if($userInfo){
            if($userInfo->is_email_verified == 1){
                $isEmailVerified = true;
            }
        }
        return $isEmailVerified;
        
    }
    /**
     * Function to check user status blocked or active
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    protected function isUserActive(Request $request)
    {
        $isUserActive = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $isUserActive = true;
        }
        if($userInfo){
            if($userInfo->status != 0 || $userInfo->status != 2){
                $isUserActive = true;
            }
        }
        return $isUserActive;
        
    }
    
    /**
     * Function to check user status blocked or active
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    protected function isUserPaid(Request $request)
    {
        $isUserPaid = false;
        $request->merge([
            'email' => base64_decode($request->email)
        ]);
        $userInfo = $this->getUserInfo($request);
        if($userInfo){
            if($userInfo->is_payment_done != 0 || $userInfo->user_type != 2){
                $isUserPaid = true;
            }
        }
        return $isUserPaid;
        
    }
    
    /**
     * Get the user profile companystatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCompanyProfileStatus(Request $request)
    {
        $IsProfileActive = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $IsProfileActive = true;
        }
        if($userInfo){
            if($userInfo->user_type == 3 && $userInfo->approve_status != 0){
                $IsProfileActive = true;
            }
        }
        return $IsProfileActive;
        
    }
    /**
     * Get the user profile companystatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCompanyProfileRejectStatus(Request $request)
    {
        $IsProfileReject = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $IsProfileReject = true;
        }
        if($userInfo){
            if($userInfo->user_type == 3 && $userInfo->approve_status != 2){
                $IsProfileReject = true;
            }
        }
        return $IsProfileReject;
        
    }
    /**
     * Get the user profile companystatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCandidateProfileStatus(Request $request)
    {
        $isMcqComplete = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $isMcqComplete = true;
        }
        if($userInfo){
            if($userInfo->user_type == 2 && $userInfo->is_mcq_complete == 1){
                $isMcqComplete = true;
            }
        }
        return $isMcqComplete;
    }
    /**
     * Get the user profile companystatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function isCompany(Request $request)
    {
        $isCompany = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $isCompany = true;
        }
        if($userInfo){
            if($userInfo->user_type == 3){
                $isCompany = true;
            }
        }
        return $isCompany;
    }
    /**
     * Get the user profile companystatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function isCandidate(Request $request)
    {
        $isCandidate = false;
        $userInfo = $this->getUserInfo($request);
        if($userInfo == null){
            $isCandidate = true;
        }
        if($userInfo){
            if($userInfo->user_type == 2){
                $isCandidate = true;
            }
        }
        return $isCandidate;
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $request->request->add(['status !=' => 0,'is_email_verified' => 1,'user_type !=' => 1]);
        return $request->only($this->username(), 'password' ,'status');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //echo 'ff'; exit;
       if(Auth::check()){
            //Insert at user login history
            $insertData = [];
            $insertData['user_id'] = Auth::user()->id;
            $insertData['login_time'] = now();
            $insertData['ip_address'] = $request->getClientIp();
            $userHistory = $this->loginUserHistory->createLoginhistory($insertData);
            if(Auth::user()->user_type == 2){ // candidate
                return redirect('/candidate/dashboard');
            }
            if(Auth::user()->user_type == 3){ // company
                return redirect('/company/dashboard');
            }
            if(Auth::user()->user_type == 1){ // admin
                $this->logout($request);
                return redirect('/');
            }
            if(Auth::user()->user_type == '' || Auth::user()->user_type == NULL){ // admin
                return redirect('/');
            }
             
        }else{
            return redirect('/');
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //protected function sendFailedLoginResponse(Request $request)
    // {
    //     throw ValidationException::withMessages([
    //        $this->username() => ['test data '],
    //     ]);
    // }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        //Insert at user logout history
        $insertData = [];
        $insertData['user_id'] = Auth::user()->id;
        $insertData['logout_time'] = now();
        $insertData['ip_address'] = $request->getClientIp();
        $userHistory = $this->loginUserHistory->createLoginhistory($insertData);
        
        $url = "/";
        $this->guard()->logout();

        $request->session()->invalidate();
        Auth::logout();
        Session::flush();
        
        //$request->session()->invalidate();

        //$request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
