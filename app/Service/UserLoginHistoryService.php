<?php 

namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\UserLoginHistory;
use Cookie;
use Carbon\Carbon;

class UserLoginHistoryService {
    
    protected $userloginhistory;
    
    public function __construct(UserLoginHistory $userloginhistory)
    {
        $this->userloginhistory = new CommonRepository($userloginhistory);
    }

    public function createLoginhistory($data){
        $insert = $this->userloginhistory->create($data);
        return $insert;
    }

    public function deleteLoginHistory(){

        $logins = $this->getAllLogginHistory();
        foreach ($logins as $key => $login) {
            $week = $login->created_at->diffInWeeks(Carbon::now());
            if($week>=10)
            {
                $this->userloginhistory->delete($login->id);
                echo 'ok';
            }
        }
        
    }
    
    public function getAllLogginHistory()
    {
       return $this->userloginhistory->all();
    }
}