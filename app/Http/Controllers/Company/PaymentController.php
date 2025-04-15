<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\PaymentService;
use App\Service\Candidate\CandidateService;
use App\Service\Company\CompanyService;
use Cartalyst\Stripe\Stripe;
use Auth;

class PaymentController extends Controller
{

   protected $paymentService; 
   protected $candidateService;
   protected $companyService;

   public function __construct(PaymentService $paymentService,CandidateService $candidateService,CompanyService $companyService)
    {   
        $this->middleware('companyAuth');
        $this->paymentService   = $paymentService;
        $this->candidateService = $candidateService;
        $this->companyService = $companyService;
    }
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */ 
    

    public function jobAdvertisement()
    {
        $plans = $this->paymentService->getPaymentValue();
        return view('frontend.company.jobAdvertisement',compact('plans'));
    }

    public function CompanyPayment(Request $request,$id)
    {
        
        $user = Auth::user();
        $paymentId = base64_decode($id);

        if($paymentId == 0){
            return redirect('/company/my-jobs/');
        }
        else{
            $employment = $this->companyService->postQuestionJobPost($request);
            return view('frontend.company.payment_info',compact('user','id'));
        }
    }

    public function CompanyPaymentProcess(Request $request)
    {
        $user       = Auth::user();
        $getRequest = $request->all();
        $id         = $getRequest['plan_id'];

        $this->validate($request, [
            'card' => 'required|numeric',
            'exp_month' => 'required|numeric',
            'cvc' => 'required|numeric',
            'exp_year' => 'required|numeric'
        ]);

        $charge =  $this->paymentService->CreateChargeForCompany($getRequest);
        if($charge)
        {
            request()->session()->flash('success-msg', __('Payment Successfull') );
            return redirect('/company/post-job/'.$id);
        }else{
            request()->session()->flash('error-msg', __('Something went wrong') );
            return redirect('company/dashboard');
        }
    }
}
