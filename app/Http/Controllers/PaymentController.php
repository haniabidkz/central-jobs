<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\PaymentService;
use App\Service\Candidate\CandidateService;
use Cartalyst\Stripe\Stripe;
use Auth;

class PaymentController extends Controller
{

   protected $paymentService; 
   protected $candidateService;

   public function __construct(PaymentService $paymentService,CandidateService $candidateService)
    {   
        $this->middleware('auth', ['except' => ['index','testCharge'] ]);
        $this->paymentService   = $paymentService;
        $this->candidateService = $candidateService;
    }
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */ 
    public function index()
    {
        $user = Auth::user();
        $data['pageTitle'] = $pageTitle = 'Payments';
        $data['metaTitle'] = $metaTitle = "Payment options";
        //$data['payment_values'] = $this->paymentService->getPaymentValue();
        $plans                          = $this->paymentService->getPlans();
        $candidates_with_highlight      = $this->candidateService->getAllCandidatesWithHighlightCV();
        $candidates_without_highlight   = $this->candidateService->getAllCandidatesWithoutHighlightCV();
        
        $data['previous_url'] = $url = redirect()->getUrlGenerator()->previous();
        return view('frontend.candidate.payment', compact('data','user','plans','candidates_with_highlight','candidates_without_highlight'));
    }
    
    /**
     * Payment of the monthly plan
     * 
     * @param \Illuminate\Http\Request  $request
     */
    public function payment(Request  $request)
    {
        $user = Auth::user();
        $paymentId = $request->id;
        $previous_url = $request->previous_url;
        
        if($paymentId == 1){
            $payment = $this->paymentService->makePayment($paymentId);
            return redirect($previous_url);
        }else if($paymentId == $user->subscription_plan_id)
        {
            return redirect('/payments')->with('message-success','You are already subscribed to this plan');
        }
        else{
            return view('frontend.candidate.payment_info',compact('user','paymentId'));
        }
    }

    public function paymentProcess(Request $request){

        $user = Auth::user();
        $getRequest = $request->all();

        $this->validate($request, [
            'card' => 'required|numeric',
            'exp_month' => 'required|numeric',
            'cvc' => 'required|numeric|digits:3',
            'exp_year' => 'required|numeric|digits:4'
        ]);

        $paymentId = $request->plan_id;
        $customer = [];
        $payment =  $this->paymentService->makePayment($paymentId,$getRequest);
        if($payment){
            return redirect('/payments')->with('message-success','Payment Successful');
        }
        
    }

    public function upgradeSubscription(Request $request)
    {
        return redirect('/');
        dd('Do Not Have pemission');
        $payment =  $this->paymentService->upgradeSubscription($getRequest);
    }
}
