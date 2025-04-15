<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Requests\Admin\PasswordUpdate;
use App\Service\AdminService;

class AdminController extends Controller {
    
    protected $adminService;
    
    /**
     * @param AdminService $adminService reference to adminService
     * 
     */
    public function __construct(
        AdminService $adminService
    ) {
        $this->adminService = $adminService;
        $this->middleware('guestAdmin')->except('logout','passwordUpdate','passwordUpdateProcess','cmsPages','cmsEdit');
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 04/02/2020
    @FunctionFor: Admin Login 
    */
    public function login(Request $request)
    {   
        
    	if($request->isMethod('post')){
            try { 
                request()->validate([
                    'email' => 'required',
                    'password' => 'required',
                ]);
                $email = $request->email;
                $password = $request->password;
                if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type' => 1])) {
                    // Authentication passed...
                    return redirect()->intended('admin/dashboard');
                    
                } else {
                    $request->session()->flash('message-error', 'Invalid cradentials.');
                    return redirect('admin/login');
                }
            } catch (Exception $e) {
               
                $request->session()->flash('message-error', 'An error occurred.');
                return redirect('admin/login');
            }
    	}
        return view('Admin/login');
    } 

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/02/2020
    @FunctionFor: Admin Change Password view page
    */

    public function passwordUpdate(Request $request) {
        try {
            $activeModule = 'passwordUpdate';
            $title        = "Password Update | Welcome to Pin the look Admin Portal";  
            $pageTitle = 'Change Password';
            return view('Admin.passwordUpdate', compact('title', 'activeModule','pageTitle'));
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/login');
        }
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/02/2020
    @FunctionFor: Admin Change Password Action
    */
    
    public function passwordUpdateProcess(PasswordUpdate $request) {
        try { 
            $result = $this->adminService->passwordUpdateAction($request->all());
            
            if($result == 'success'):
                Session::flush();
                Auth::logout();
                $request->session()->flash('message-success', 'Password changed successfully.');
                return Redirect('admin/login');
                // return redirect('admin/logout');
            else:
                $request->session()->flash('message-error', 'Old password is not right.');
                return redirect()->back();
            endif;         
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/login');
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 04/02/2020
    @FunctionFor: Admin Logout 
    */
    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        $request->session()->flash('message-success', "Admin Log Out Successfully");
        return Redirect('admin/login');
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/02/2020
    @FunctionFor: Admin Forgot Password
    */

    public function forgotPassword(Request $request) {
        try {
            $activeModule = 'forgotPassword';
            $title        = "Forgot Password | Welcome to Pin the look Admin Portal";  

            return view('Admin.forgotPassword', compact('title', 'activeModule'));
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/login');
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 04/02/2020
    @FunctionFor: Forgot Password Mail Verification and sent a verification link to admin email
    */
    public function verifyEmail(Request $request) {
        try { 
            request()->validate([
                'email' => 'required'
            ]);
            $result = $this->adminService->verifyEmail($request->all());
            if($result == 'success'):
                $request->session()->flash('message-success', 'An email has been sent to your registered email id with the reset password link.');
                return redirect()->back();
            else:
                $request->session()->flash('message-error', 'Please Check your email to continue.');
                return redirect()->back();
            endif;         
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/login');
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 04/02/2020
    @FunctionFor: Reset Password
    */
    public function resetPassword(Request $request) {
        
        if($request->isMethod('post')){
            $email = $request['email'];   
            $token = $request['token']; 
            try { 
                request()->validate([
                    'email' => 'required',
                    'password' => 'required|confirmed|min:6',
                    'password_confirmation' => 'required'
                ]);
                
                $result = $this->adminService->resetPassword($request->all());
               
                if($result == 'success'){
                    $request->session()->flash('message-success', 'Password changed successfully.');
                    return redirect('admin/login');
                } 
                elseif($result == 'error'){
                    $request->session()->flash('message-error', 'New password can not be same as old password.');
                    return redirect('admin/reset-password/'.$token);
                }
                else {
                    $request->session()->flash('message-error', 'Invalid user token.');
                    return redirect('admin/reset-password/'.$token); 
                }
                
            } catch (Exception $e) {
                $request->session()->flash('message-error', 'An error occurred.');
                return redirect('admin/reset-password/'.$token);
            }
        }else{
            // Check token expire or not
            $result = $this->adminService->verifyToken($request['token']);
            if($result == 'error'){
                $request->session()->flash('message-error', 'The token has been expired.');
                return redirect('admin/login');
            }else{
                $token = $request['token'];
                return view('Admin/resetPassword',compact('token'));
            }
        }
        
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: All Cms pages
    */
    public function cmsPages() {
        $cmsList = $this->adminService->fetchList();
        $activeModule = 'cmsPages';
        return view('Admin.cmsList', compact('cmsList', 'activeModule'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Cms page edit
    */
    public function cmsEdit(Request $request) {
        if($request->isMethod('post')){
            $result = $this->adminService->updateDetails($request);
            if($result == 'success'){
                $request->session()->flash('message-success', 'Cms updated successfully.');
                return redirect()->back();
            }else{
                $request->session()->flash('message-error', 'Something went wrong, please try again.');
                return redirect()->back();
            } 
        }else{
            $id = decrypt($request['id']);
            $details = $this->adminService->details($id);
            $activeModule = 'cmsPages';
            return view('Admin.cmsEdit', compact('details', 'activeModule'));
        }
        
    }


}
