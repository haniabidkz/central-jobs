<?php 

namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\Subscription;

class SubscriptionService {
    
    protected $subscriptionRepository;

    public function __construct(Subscription $subscription)
    {
        $this->subscriptionRepository = new CommonRepository($subscription);
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription get all list
    */
    public function getAllList($request)
    {   
        $data = $request->all();
        $condition  = [];
        if(request()->input('start_date',false) != false){
            $condition [] = ['start_date','>=',$data['start_date']];
        } 
        if(request()->input('end_date',false) != false){
            $condition [] = ['end_date','<=',$data['end_date']];
        }
        if(request()->input('status',false) != false){
            if($data['status'] == 2){
                $data['status'] = 0;
            }
            $condition [] = ['status','=',$data['status']];
        }
        if(request()->input('title',false) != false){
            $condition [] = ['title','Like','%'.$data['title'].'%'];
        }    
        $limit = env('ADMIN_PAGINATION_LIMIT');
        $subscription = $this->subscriptionRepository->get($condition,$limit);     
        return $subscription;
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription update or change status
    */
    public function updateSubscription($request)
    {   
        $id = $request['id'];    
        $subscription = $this->subscriptionRepository->update($request,$id);     
        return $subscription;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription delete
    */
    public function subscriptionDelete($id){
        $subscription = $this->subscriptionRepository->delete($id);     
        return $subscription;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription details
    */
    public function getDetails($id){
        $id = decrypt($id);
        $subscription = $this->subscriptionRepository->show($id);     
        return $subscription;
    }
    /*
     @DevelopedBy: Israfil
     @Date: 25/03/2020
     @function to get active serveces
     */
    public function getActiveSubscriptions()
    {
        $limit = 10000;
        $condition = [['status','=',1]];
        $subscriptions = $this->subscriptionRepository->get($condition,$limit);  
        return $subscriptions;
    }
    /*
     @DevelopedBy: Rumpa Ghosh
     @Date: 25/03/2020
     @function add subscription
     */
     public function subscriptionAdd($request){
        $request = $request->all();
        return  $this->subscriptionRepository->create($request);
     }
    /*
     @DevelopedBy: Rumpa Ghosh
     @Date: 25/03/2020
     @function edit subscription
     */ 
    public function subscriptionEdit($request){
        $request = $request->all();
        $id = $request['id'];
        return  $this->subscriptionRepository->update($request,$id);
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription get all list
    */
    public function getList()
    {   
        $subscription = $this->subscriptionRepository->all();   
        return $subscription;
    }
}