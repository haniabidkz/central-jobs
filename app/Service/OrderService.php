<?php 

namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\Order;
use App\Http\Model\Subscription;
use App\Http\Model\SubscriptionHistory;
use App\Jobs\SendEmailOrderClosed;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\OrderPaymentLinkMail;
use App\Mail\ServiceRequestMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Http\Model\User;

class OrderService {
    
    protected $orderRepository;
    protected $subscription;
    protected $subscriptionHistory;
    protected $user;

    public function __construct(Order $order,Subscription $subscription,SubscriptionHistory $subscriptionHistory,User $user)
    {
        $this->orderRepository = new CommonRepository($order);
        $this->subscription = new CommonRepository($subscription);
        $this->subscriptionHistory = new CommonRepository($subscriptionHistory);
        $this->user = new CommonRepository($user);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Order all list 
    */
    public function getAllList($request)
    {   
        $data = $request->all();
        $condition  = [];
        if(request()->input('candidate_name',false) != false){
            $condition [] = ['candidate_name','LIKE','%'.$data['candidate_name'].'%'];
        }
        if(request()->input('candidate_email',false) != false){
            $condition [] = ['candidate_email','LIKE','%'.$data['candidate_email'].'%'];
        } 
        if(request()->input('start_date',false) != false){
            $filterData['start_date'] = date('Y-m-d',strtotime($data['start_date']));
            $from    = Carbon::parse($filterData['start_date'])
                     ->startOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
            $condition [] = ['service_start_from','>=',$from];
        } 
        if(request()->input('end_date',false) != false){
            $filterData['end_date'] = date('Y-m-d',strtotime($data['end_date']));
            $to    = Carbon::parse($filterData['end_date'])
                     ->endOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
                     //$to = $to . " 12:59:59";
            $condition [] = ['service_start_from','<=',$to];
        }
        if(request()->input('status',false) != false){
            if($data['status'] == 4){
                $data['status'] = 0;
            }
            $condition [] = ['status','=',$data['status']];
        }
        $limit = env('ADMIN_PAGINATION_LIMIT',10);
        $relation = ['subscription_history','user'];
        $order = $this->orderRepository->getWith($condition,$limit,$relation);     
        return $order;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Order details 
    */
    public function getDetails($data){
        $id = $data['id'];
        $where = [['id',$id]];
        $relation = ['subscription_history'];
        $order = $this->orderRepository->showWith($where,$relation);     
        return $order;
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 19/03/2020
    @FunctionFor: Order update or change status and sentd mail to candidate
    */
    public function updateOrder($request)
    {   
        $id = $request['id'];   
        $order = $this->orderRepository->update($request,$id);
        if(($order != NULL) && isset($request['status']) && ($request['status'] == 3)){
            $data['id'] = $id;
            $userDetail = $this->getDetails($data);
            dispatch(new SendEmailOrderClosed($userDetail));
        } 
        return $order;
    }
   /*
    @DevelopedBy: Israfil
    @Date: 29/03/2020
    @FunctionFor: Order update 
    */
    public function editOrder($request)
    {   
        $id = $request['id'];   
        $orderDetails = $this->orderRepository->show($id)->toArray();
        if($orderDetails['subscription_id'] != $request['subscription_id']){
            $serviceId = $request['subscription_id'];
            $details = $this->subscription->show($serviceId)->toArray();
            $details['service_id'] = $serviceId;
            unset($details['id']);
            $history = $this->subscriptionHistory->update($details,$orderDetails['subs_history_id']);
        }
        $request['status'] = 0;
        $order = $this->orderRepository->update($request,$id);
        if($order){
            $mailData = $this->orderRepository->show($id)->toArray();
            $serviceId = $request['subscription_id'];
            $subscription = $this->subscription->show($serviceId)->toArray();
            $mailData['payment_link'] = $mailData['payment_url'];
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $mailData['imgPath'] = $imgPath;
            $mailData['logoPath'] = $logoPath;
            $mailData['service_name'] = $subscription['title'];
            
            //$request['payment_link'] = env('APP_URL').'public/subscription-payment/'.$orderEncryptedId;
            $this->sendPaymentLinkToCandidate($mailData);
        }
        return $order;
    }
    /**
     * Developer : Israfil
     * Function to send 
     * @param array $orderInfo
     * @return Void
     */
    public function sendPaymentLinkToCandidate($orderInfo)
    {
        Mail::to($orderInfo['candidate_email'])->send(new OrderPaymentLinkMail($orderInfo));
    }
    public function sendPaymentLinkToAdmin($orderInfo)
    {
        //$admin = $this->user->show(1)->toArray();
        $email = env('SUPPORT_EMAIL_ID','info@central-jobs.com');
        Mail::to($email)->send(new ServiceRequestMail($orderInfo));
    }
     /**
     * @DevelopedBy: Israfil
     * @Date: 26/03/2020
     * @function to add new subscription order info
     * @param array $request
     * @return integer $status
     */
    public function addSubscriptionOrderInfo($request)
    {
        $serviceId = $request['subscription_id'];
        $details = $this->subscription->show($serviceId)->toArray();
        $details['service_id'] = $serviceId;
        unset($details['id']);
        $history = $this->subscriptionHistory->create($details);
        $request['subscription_code'] = $this->generateServiceCode(); 
        $request['subs_history_id'] = $history->id;  
        $status =  $this->orderRepository->create($request);
        if($status){
            $orderEncryptedId = encrypt($status->id);
            $request['payment_link'] = $request['payment_url'];
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $request['imgPath'] = $imgPath;
            $request['logoPath'] = $logoPath;
            $request['service_name'] = $details['title'];
            //$request['payment_link'] = env('APP_URL').'public/subscription-payment/'.$orderEncryptedId;
            $this->sendPaymentLinkToCandidate($request);
        }
        return $status;
    }
     /*
     @DevelopedBy: Israfil
     @Date: 19/03/2020
     @function to delete new subscription order info
     */
    public function deleteOrder($id)
    {
        return  $this->orderRepository->delete($id);
    }
     /*
     @DevelopedBy: Israfil
     @Date: 29/03/2020
     @function to genrate service code
     */
    public function generateServiceCode()
    {
        $serviceCode = 'MRH'.date('dmYhis');
        return $serviceCode;
    }
    /**
     * Developer : israfil
     * Function download payment reports
     * @return array $paymentReport
     */
    public function getPaymentReport($request)
    {   
        $data = $request->all();
        $seacrh = false;
        $condition  = [];
        // if(request()->input('candidate_name',false) != false){
        //     $condition [] = ['candidate_name','LIKE','%'.$data['candidate_name'].'%'];
        //     $seacrh = true;
        // }
        // if(request()->input('candidate_email',false) != false){
        //     $condition [] = ['candidate_email','LIKE','%'.$data['candidate_email'].'%'];
        //     $seacrh = true;
        // } 
        if(request()->input('start_date',false) != false){
            $filterData['start_date'] = date('Y-m-d',strtotime($data['start_date']));
            $from    = Carbon::parse($filterData['start_date'])
                     ->startOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
            $condition [] = ['created_at','>=',$from];
            $seacrh = true;
        } 
        if(request()->input('end_date',false) != false){
            $filterData['end_date'] = date('Y-m-d',strtotime($data['end_date']));
            $to    = Carbon::parse($filterData['end_date'])
                     ->endOfDay()        // 2018-09-29 00:00:00.000000
                     ->toDateTimeString();
            $condition [] = ['created_at','<=',$to];
            $seacrh = true;
        }
        if(request()->input('subscription_id',false) != false){
            $condition [] = ['subscription_code','=',$data['subscription_id']];
            $seacrh = true;
        }
        if(request()->input('status',false) != false){  
            if($data['status'] == 4){
                $data['status'] = 0;
            }
            $condition [] = ['status','=',$data['status']];
            $seacrh = true;
        }
        if(request()->input('service_id',false) != false){
            $condition [] = ['subscription_id','=',$data['service_id']];
            $seacrh = true;
        }
       
        $limit = env('ADMIN_PAGINATION_LIMIT',10);
        $relation = ['subscription_history','user'];
        $order = [];
        if($seacrh){
            $order = $this->orderRepository->getWith($condition,$limit,$relation); 
        }
            
        return $order;
    }
  /**
   * Developed by Israfil
   * @param array $search
   * @return file
   */
  public function downloadPaymentReport($request)
  {
        $timeStamp = time();
        $generatedDateTime = date('Y-m-d h:i a',$timeStamp);
        $payments = $this->getPaymentReport($request);
        $exportArray = [];
        $reportRow =  [' ','Report Name','Payment Report',' ',' ','Generated On',$generatedDateTime,' '];
        $blankRow  =  [' ',' ',' ',' ',' ',' ',' ',' '];
        $rowTitle  =  ['Sl No','Subscription Id','Subscription Date','Candidate Name','Candidate Email','Service Name','Amount(R$)','Additional Information','Payment Status'];
        array_push($exportArray,$reportRow);
        array_push($exportArray,$blankRow);
        array_push($exportArray,$rowTitle);
        if (!empty($payments) && (count($payments) != 0)) {
            $count = 0;
            foreach($payments as $key => $val)
            {
                $data = [];
                $count++;
                $data[] = $count;
                $data[] = $val['subscription_code'];
                $data[] = date('Y-m-d', strtotime($val['created_at']));
                if($val['candidate_name'] != ''){
                    $data[] = $val['candidate_name'];
                }else{
                    $data[] = 'N/A';
                }
                $data[] = $val['candidate_email'];
                $data[] = $val['subscription']['title'];
                if($val['amount'] != ''){
                    $data[] = $val['amount'];
                }else{
                    $data[] = 'N/A';
                }
                if($val['additional_info'] != ''){
                    $data[] = $val['additional_info'];
                }else{
                    $data[] = 'N/A';
                }
                if ($val['status'] == 0) {
                    $data[] = 'Payment Pending';
                } else if($val['status'] == 1){
                    $data[] = 'Inprogress';
                }
                else if($val['status'] == 2){
                    $data[] = 'Paid';
                }else{
                    $data[] = 'Subscription Closed';
                }
                array_push($exportArray,$data);
            }
            
            $export = new PaymentsExport($exportArray);
            $excelFileName = "Payment_Report_".date('d_m_Y_h:i_a',$timeStamp).'.xlsx';
            return  Excel::download($export, $excelFileName);
  }
}

/**
     * @DevelopedBy: Israfil
     * @Date: 26/03/2020
     * @function to add new subscription order info
     * @param array $request
     * @return integer $status
     */
    public function requestSubscription($request)
    {
        $serviceId = $request['subscription_id'];
        $details = $this->subscription->show($serviceId)->toArray();
        $details['service_id'] = $serviceId;
        unset($details['id']);
        if((isset($data['privacy_policy_status'])) && $data['privacy_policy_status'] == "on"){
            $data['privacy_policy_status'] = 1;
        }
        if((isset($data['cookies_policy_status'])) && $data['cookies_policy_status'] == "on"){
            $data['cookies_policy_status'] = 1;
        }
        if((isset($data['terms_conditions_status'])) && $data['terms_conditions_status'] == "on"){
            $data['terms_conditions_status'] = 1;
        }
        $history = $this->subscriptionHistory->create($details);
        $request['subscription_code'] = $this->generateServiceCode(); 
        $request['subs_history_id'] = $history->id;  
        $request['status'] = 1; 
        $status =  $this->orderRepository->create($request);
        if($status){
            $request['service_name'] = $details['title'];
            $this->sendPaymentLinkToAdmin($request);
        }
        return $status;
    }

}
