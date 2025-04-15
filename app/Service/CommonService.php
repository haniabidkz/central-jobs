<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Repository\CommonRepository;
use App\Http\Model\User;
use App\Http\Model\Notification;
use Exception;
use Auth;


class CommonService {

    protected $user;
    protected $notification;

    /**
     * @param user $user reference to user model
     * 
     */
    public function __construct(User $user,Notification $notification) {
        $this->user = new CommonRepository($user);
        $this->notification = new CommonRepository($notification);
    }
    
    /**
     * Function to get logged usr basic information to 
     * accross all pages to header section
     * @return $resultSet $userInformation
     */
    public function getUserSharedInfo()
    {
        $userInformation = false;
        if(Auth::check()){
             $condition = [['id',Auth::user()->id]];
             $relations = ['profileImage'];
             $userInformation = $this->user->showWith($condition,$relations);    
        }        
        return $userInformation;
    }
    /**
     * Function to get logged usr basic information to 
     * accross all pages to header section
     * @return $resultSet $adminInformation
     */
    public function getEmailId()
    {
        $adminEmail = User::select('email')->where('id', 1)->first();       
        return $adminEmail;
    }
    /**
     * Function to get logged usr basic information to 
     * accross all pages to header section
     * @return $resultSet $userInformation
     */
    public function getUserNotification()
    {
        $userNotification = false;
        if(Auth::check()){
            $userId = Auth::user()->id;
            $limit = '';
            $condition = [['to_user_id',$userId],['status',1]];
            $relations = ['message','user'];
            $whereIn = ['message','connection_request','connection_accepted','connection_rejected','job','follow','comment','like','share_post'];
            $type = 'type';
            $userNotification = $this->notification->getWithNoPagination($condition, $limit, $relations,$type,$whereIn); 
        }        
        return $userNotification;
    }

    public function getUserNewNotification(){
        $userNewNotification = false;
        if(Auth::check()){
            $userId = Auth::user()->id;
            $limit = '';
            $condition = [['to_user_id',$userId],['status',1],['seen_status',0]];
            $relations = ['message','user'];
            $whereIn = ['message','connection_request','connection_accepted','connection_rejected','job','follow','comment','like','share_post'];
            $type = 'type';
            $userNewNotification = $this->notification->getWithNoPagination($condition, $limit, $relations,$type,$whereIn)->count(); 
        }        
        return $userNewNotification;
    }

    public function changeStatus($id){
        $data['seen_status'] = 1;
        $message = $this->notification->update($data,$id);
        return $message;
    }
}