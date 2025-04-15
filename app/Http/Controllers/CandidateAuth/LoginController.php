<?php

namespace App\Http\Controllers\CandidateAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Validation\ValidationException;

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
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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
        
        if ($this->attemptLogin($request)) {
            $request->merge([
                'email' => base64_decode($request->email)
            ]);
            //check is user Paid
            $isUserPaid = $this->isUserPaid($request);

            if(!$isUserPaid){
                return redirect('/payments/');
            }
            //check if user is candidate account screening question
            $isCandidate = $this->isCandidate($request);
            if($isCandidate){
                $this->getUserInfo($request);
                return redirect()->back();
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $request->merge([
            'email' => base64_encode($request->email)
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
        $userInfo = $this->getUserInfo($request);
        if($userInfo){
            if($userInfo->is_payment_done != 0 ){
                $isUserPaid = true;
            }
        }
        return $isUserPaid;
        
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
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
           $this->username() => ['Email or password is not correct.'],
        ]);
    }
}
