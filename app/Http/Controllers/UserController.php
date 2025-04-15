<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Service\SubscriptionService;
class UserController extends Controller
{
    
    protected $orderService;
    protected $subscriptionService;
    public function __construct(OrderService $orderService,SubscriptionService $subscriptionService)
    {   
        
        $this->middleware('auth', ['except' => array('payment','signIn')]);
        $this->orderService = $orderService;
        $this->subscriptionService = $subscriptionService;
    }
    /**
     * Developer : Israfil
     * Function to show Dashboard
     *
     */ 
    public function dashboard()
    {
        return view('frontend.candidate.dashboard');
    }
    /**
     * Function to sign up layout
     */
    public function signIn()
    {
        return view('frontend.sign_in.signin');
    }
    /**
     * Developer : Israfil 
     * Function to proceed payment for subscription
     * @param integer $paymentId
     */
    public function payment($paymentId)
    {
        $data['id'] = decrypt($paymentId);
        $orderInformation = $this->orderService->getDetails($data);
        if(!$orderInformation){
            return redirect('/');
        }
        $pageTitle = "Service Details";
    	return view('frontend.payment.payment',compact("pageTitle","orderInformation"));
    }
}
