<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\PaymentService;
use App\Service\OrderService;
use App\Service\SubscriptionService;
use App\Service\Candidate\CandidateService;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;


class PaymentController extends Controller
{
    protected $paymentService;
    protected $subscriptionService;
    protected $orderService;
    protected $candidateService;

    public function __construct(PaymentService $paymentService,SubscriptionService $subscriptionService,OrderService $orderService,CandidateService $candidateService)
    {
        $this->paymentService = $paymentService;
        $this->subscriptionService = $subscriptionService;
        $this->orderService = $orderService;
        $this->candidateService = $candidateService;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/03/2020
    @FunctionFor: Payment list
    */
    public function index(Request $request)
    {

        $search = $request->all();
        $payments = $this->orderService->getPaymentReport($request); 
        $serviceList = $this->subscriptionService->getList();
        $activeModule = "payment";
        $pageTitle = 'Download Payment reports';
        return view('Admin.Payment.list', compact("payments", "activeModule", 'search','pageTitle','serviceList'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Order details popup
    */
    public function downloadDetails(Request $request)
    {
         $search = $request->all();
         return $this->orderService->downloadPaymentReport($request);
    }
    
    /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: All BestAdvertisement listing
    */
    public function list(Request $request) {
        $payments = $this->paymentService->fetchList();
        $activeModule = 'paymentCms';
        $pageTitle = 'Payment Cms List';
        return view('Admin.payment-cms.list', compact('payments', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category edit
    */
    public function edit(Request $request, $id) {
        $id = decrypt($request['id']);
        $details = $this->paymentService->details($id);
        $activeModule = 'paymentCms';
        $pageTitle = 'Payment Cms Edit';
        return view('Admin.payment-cms.add', compact('details', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category edit post
    */
    public function editPost(Request $request){
        $data = $this->paymentService->updateDetails($request);
        request()->session()->flash('message-success', "Payment Amount updated successfully");
        return redirect('admin/payment-cms-list');
    }

     /*
    @FunctionFor: Stripe product listing
    */

    public function productList() {
        $plans = $this->paymentService->getPlans();
        
        $activeModule = 'paymentCms';
        $pageTitle = 'Stripe Products List';

        return view('Admin.Stripe.list', compact('plans', 'activeModule','pageTitle'));
    }

    public function editProductList(Request $request,$id)
    {
        $id = decrypt($request['id']);
        $plan = $this->paymentService->getPlanDetailsById($id);

        $activeModule = 'paymentCms';
        $pageTitle = 'Stripe Products Edit';
        
        return view('Admin.Stripe.edit',compact('plan','activeModule','pageTitle'));
    }

    public function changeProductActiveStatus(Request $request,$id,$status)
    {
        $id = decrypt($request['id']);
        $plan = $this->paymentService->changePlanStatus($id,$status);
        if($plan)
        {
            return redirect('admin/product-list')->with('message-success','Product status changed');
        }
    }

    public function editProduct(Request $request)
    {
        $plan = $this->paymentService->updatePlanDetailsById($request);
        if($plan)
        {
            return redirect('admin/product-list')->with('message-success', 'Plan Updated Successfully!!');

        }else{
            return redirect('admin/product-list')->with('message-error', 'Something went wrong');
        }
    }

    public function updateHighlights($candidateId,$val)
    {
        $candidate = $this->candidateService->changeHighlightStatus($candidateId,$val);
        if($candidate)
        {
            return redirect('admin/candidate-list')->with('message-success','Highlight Status Changes');
        }else{
            return redirect('admin/candidate-list')->with('message-error','Something went wrong');
        }
    }

    public function createProduct(){

        $activeModule = 'paymentCms';
        $pageTitle = 'Stripe Products Add';
        
        return view('Admin.Stripe.add',compact('activeModule','pageTitle'));
        //return view('admin.subscription.createPlan');
    }

    public function addProduct(Request $request){

        $plan = $this->paymentService->addProduct($request);
        if($plan)
        {
            return redirect('admin/product-list')->with('message-success', 'Plan Added Successfully!!');

        }else{
            return redirect('admin/product-list')->with('message-error', 'Something went wrong');
        }
    }

    
    public function CandidatetransactionList()
    {
        $activeModule = 'CandidateTransaction';
        $pageTitle = 'Candidate Transactions';
        $candidates = $this->paymentService->CandidatetransactionList();
        return view('Admin.Transactions.candidateList',compact('activeModule','candidates','pageTitle'));
    }

    public function CompanyTransactionList()
    {
        $activeModule = 'CompanyTransaction';
        $pageTitle = 'Company Transactions';
        $companies = $this->paymentService->CompanyTransactionList();
        return view('Admin.Transactions.companyList',compact('activeModule','companies','pageTitle'));
    }
}
