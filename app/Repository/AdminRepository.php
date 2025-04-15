<?php
namespace App\Repository;
use App\Model\Admin;
use App\Http\Model\User;
use App\Http\Model\PasswordReset;
use App\Http\Model\Cms;
use Auth;
use Hash;

class AdminRepository {

    /**
     * Update admin model
     * @param array $data
     * @param array $condition
     * @return Admin
     */
    public function update(array $data, array $condition) {
        Admin::where($condition)
                  ->update($data);
    }

     /**
     * Fetch default content of invitation
     * @return Admin
     */
    public function fetchAdminSetting() {
        return Admin::find(1)->first();
    }


    public function passwordUpdateAction($attributes)
    {
        $oldPassword    = $attributes['oldPassword'];
        $password       = $attributes['password'];
        $id = Auth::user()->id;
        $userData = User::where('id',$id)->first();
        
        $current_password = $userData['password'];
        
        if(Hash::check($oldPassword, $current_password)):
                User::where('id',$id)->update(['password'=>Hash::make($password) ]);
        return 'success';

        else:
        return 'error';
                
        endif;
    }
    
    /**
     * Create user model
     * @param array $data
     * @return PasswordReset
     */
    public function createToken(array $data) {
        $user = PasswordReset::create($data);
        return $user;
    }

    /**
     * Fetch default content of invitation
     * @return Admin
     */
    public function fetchPasswordDetails($condition) {
        return PasswordReset::where($condition)->first();
    }

    /**
     * Update admin model
     * @param array $data
     * @param array $condition
     * @return Admin
     */
    public function updateToken(array $data, array $condition) {
        PasswordReset::where($condition)->update($data);
    }

    /**
     * Update admin model
     * @param array $data
     * @param array $condition
     * @return Admin
     */
    public function passwordResetAction($attributes)
    {
        $email    = $attributes['email'];
        $password       = $attributes['password'];
        $adminData = User::where('email',$email)->first();
        
        $current_password = $adminData['password'];
        
        if(!Hash::check($password, $current_password)):
                User::where('id',$adminData['id'])->update(['password'=>Hash::make($password) ]);
                PasswordReset::where('email', $email)->delete();
        return 'success';

        else:
        return 'error';
                
        endif;
    }

    /**
     * Get ambassador list
     * @return ambassadors
     */
    public function get($search = '') {
        $company = Cms::all();
        return $company;
    }

    /**
     * Find a particular cms Details
     * @param array $condition
     * @return CMS Details
     */
    public function findOne($condition) {
        $cmsDetail = Cms::where($condition)->first();
        return $cmsDetail;
    }

     /**
     * Update admin model
     * @param array $data
     * @param array $condition
     * @return Admin
     */
    public function updateDetails(array $data, array $condition) {
        $cmsDetail = Cms::where($condition)
                  ->update($data);
                  
        return $cmsDetail;          
    }

}