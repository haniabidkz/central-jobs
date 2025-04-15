<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;


class LogoutService {
    

    /**
     * @param AdminRepository $adminRepo reference to adminRepo
     * @param UserRepository $userRepo reference to userRepo
     * 
     */
    public function __construct() {
        
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logoutUser()
    {
        $url = "/";
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect($url);
    }
}