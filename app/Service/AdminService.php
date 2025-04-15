<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\ResetPasswordNotification;


class AdminService {
    
    protected $adminRepo;
    protected $userRepo;

    /**
     * @param AdminRepository $adminRepo reference to adminRepo
     * @param UserRepository $userRepo reference to userRepo
     * 
     */
    public function __construct(
        AdminRepository $adminRepo,
        UserRepository $userRepo
    ) {
        $this->adminRepo = $adminRepo;
        $this->userRepo = $userRepo;
    }
    
    /**
     * Update Admin details
     * @param array $data
     */
    public function update($data)
    {
        $id = Auth::user()->id;
        $admin_id = Auth::user()->profile->id;
        $this->userRepo->update($data["user"],[["id",$id]]);
        $this->adminRepo->update($data["admin"],[["id",$admin_id]]);

    }

    /**
     * Update Admin password
     * @param array $attributes
     */

    public function passwordUpdateAction($attributes)
    {
        return $this->adminRepo->passwordUpdateAction($attributes);
    }

    /**
     * @DevelopedBy : Rumpa Ghosh
     * @date: 05/02/2020
     * @FunctionFor: Forgot password email verification and sent link
     * Update Admin password
     * @param array $attributes
     */

    public function verifyEmail($attributes)
    {
        $result = $this->userRepo->verifyAdminEmail($attributes);
        if($result == NULL){
            return 'error';
        }else{
            //Send Mail to Admin
            $rememberToken = microtime();
            $encryptRememberToken =  encrypt($rememberToken);
            $data = [];
            $data['email'] = $attributes['email'];
            $data['name'] = $result['first_name'].' '.$result['last_name'];
            $data['token'] = $encryptRememberToken;
            $data['imgPath'] = env('APP_URL').'public/backend/dist/img/user.png';
            $data['logoPath'] = env('APP_URL').'public/frontend/images/logo-color.png';
            try{
                Mail::to($attributes['email'])->send(new ResetPassword($data['name'],$encryptRememberToken,$data['imgPath'],$data['logoPath']));
                $condition = [ [ 'email',$attributes['email'] ]];
                $result1 = $this->adminRepo->fetchPasswordDetails($condition);
        
                if($result1){
                    $updateData['token'] = $encryptRememberToken;
                    $condition = [ [ 'email',$attributes['email'] ]];
                    $this->adminRepo->updateToken($updateData,$condition);
                }else{
                    $this->adminRepo->createToken($data);
                }
                
                return 'success';
            }catch (Exception $e) {
                print_r($e->getMessage()); die();
               return 'error';
            }
            
        }
    }

    /**
     * @DevelopedBy : Rumpa Ghosh
     * @date: 05/02/2020
     * @FunctionFor: Forgot password token verification 
     * Update Admin password
     * @param array $attributes
     */

    public function verifyToken($attributes)
    {   
        $condition = [ [ 'token',$attributes ]];
        $result = $this->adminRepo->fetchPasswordDetails($condition);
    
        if($result == NULL){
            return 'error';
        }else{

            $addedTime = strtotime($result['updated_at']);
            $expTime = 1800; // 30 min
            $currentTime = time();
           
            if(($currentTime - $addedTime) > $expTime) {
                return 'error';
            }else{
                return 'success';
            }
            
        }
    }

    /**
     * @DevelopedBy : Rumpa Ghosh
     * @date: 05/02/2020
     * @FunctionFor: Reset password
     * Update Admin password
     * @param array $attributes
     */

    public function resetPassword($attributes){
        $condition = [ [ 'token',$attributes['token'] ],[ 'email',$attributes['email']]];
        $result = $this->adminRepo->fetchPasswordDetails($condition);
        if($result == NULL){
            return 'user-error';
        }else{
            $result = $this->adminRepo->passwordResetAction($attributes);
            //dd($result);
            return $result;
        }
    }

    /** 
     * Get All CMS List
    */
    public function fetchList() {
        return $this->adminRepo->get();
    }

    /** 
     * Get Details of cms page with ID
     * @param array $id
    */
    public function details($id){
        return $this->adminRepo->findOne([ ["id",$id] ]);
    }

    /**
     * Update Admin details
     * @param array $data
     */
    public function updateDetails($data)
    {
        $updateData = [];
        $updateData['title'] = $data['title'];
        $updateData['meta_title'] = $data['meta_title'];
        $updateData['meta_desc'] = $data['meta_desc'];
        $updateData['description'] = $data['description'];
        $result = $this->adminRepo->updateDetails($updateData,[["id",$data['id']]]);
        if($result == NULL){
            return 'error';
        }else{
            return 'success';
        }
    }


    public function verifyEmailUser($attributes,$token)
    {
        $email['email'] = $attributes['email'];  
        $result = $this->userRepo->verifyUserEmail($email);
        if($result == NULL){
            return 'error';
        }else{
            //Send Mail to Admin
            $email = base64_decode($attributes['email']); 
            $encryptRememberToken =  $token;
            $data = [];
            $data['email'] = $email;
            $data['name'] = base64_decode($result['first_name']).' '.$result['last_name'];
            $data['token'] = $encryptRememberToken;
            $data['imgPath'] = env('APP_URL').'public/backend/dist/img/user.png';
            $data['logoPath'] = env('APP_URL').'public/frontend/images/logo-color.png';
            try{
                Mail::to($email)->send(new ResetPasswordNotification($data,$encryptRememberToken,$data['imgPath']));
                $condition = [ [ 'email',$email ]];
                $result1 = $this->adminRepo->fetchPasswordDetails($condition);
        
                if($result1){
                    $updateData['token'] = $encryptRememberToken;
                    $condition = [ [ 'email',$email ]];
                   // $this->adminRepo->updateToken($updateData,$condition);
                }else{
                   // $this->adminRepo->createToken($data);
                }
                return 'success';
            }catch (Exception $e) {
                print_r($e->getMessage()); die();
               return 'error';
            }
            
        }
    }
}