<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Service\AdminService;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    protected $adminService;
    
    /**
     * @param AdminService $adminService reference to adminService
     * 
     */
    public function __construct(
        AdminService $adminService
    ) {
        $this->adminService = $adminService;
    }


    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $request->merge([
            'email' => base64_encode($request->email),
        ]);
        $user = User::where('email', $request->email)->first();
        $token = $this->broker()->createToken($user);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token]);

         //$token = $this->broker()->sendResetLink($request->all());        
         $result = $this->adminService->verifyEmailUser($request->all(),$token);
         if($result == 'success'){
            return back()->with('status', __('messages.FORGOT_PASSWORD_SUCCESS_MSG'));
         }else{
            return back()->with('error_status', __('messages.FORGOT_PASSWORD_ERROR_MSG'));
         }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // $response = $this->broker()->sendResetLink(
        //     $this->credentials($request)
        // );

        // return $response == Password::RESET_LINK_SENT
        //             ? $this->sendResetLinkResponse($request, $response)
        //             : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function credentials(Request $request)
    {
        $request->merge([
            'email' => base64_encode($request->email),
        ]);
        return $request->only('email');
    }


}
