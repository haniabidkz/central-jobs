<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\SubscriptionService;
use App\Http\Requests\Admin\SubscriptionRequest;

class SubscriptionController extends Controller
{
    protected $subscriptionService;
    public function __construct(SubscriptionService $subscriptionService)
    {   
        $this->subscriptionService = $subscriptionService;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription list
    */
    public function index(Request $request)
    {
        $search = $request->all();
        $subscriptions = $this->subscriptionService->getAllList($request);
        $activeModule = "subscription";
        $pageTitle = 'Service List';
        return view('Admin.Subscription.list', compact("subscriptions","activeModule","search","pageTitle"));
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription status change
    */
    public function SubscriptionChangeStatus(Request $request){
        $data = $request->all(); 
        $subscriptions = $this->subscriptionService->updateSubscription($data);
        if($subscriptions == true){
            request()->session()->flash('message-success', "Status changed successfully" );
            return 1;
        }else{
            request()->session()->flash('message-error', "Something went wrong, please try again." );
            return 0;
        }
        
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription delete
    */
    public function subscriptionDestroy($id){
        try{
            $subscriptions = $this->subscriptionService->subscriptionDelete($id);
            request()->session()->flash('message-success', "Subscription deleted successfully" );
            return redirect()->back();
        }  catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Subscription can not be deleted. This subscription associated with an order." );
            return redirect()->back();
        }
        
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Subscription detail page
    */
    public function viewSubscriptionDetails($id){
        $details = $this->subscriptionService->getDetails($id);
        $activeModule = "subscription";
        $pageTitle = 'Subscription Details';
        return view('Admin.Subscription.view', compact("details","activeModule","pageTitle"));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 02/04/2020
    @FunctionFor: Subscription add 
    */
    public function subscriptionAdd(Request $request){
        $activeModule = 'subscription';
        $pageTitle = 'Subscription Add';
        return view('Admin.Subscription.add-edit', compact('activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 02/04/2020
    @FunctionFor: Subscription add post
    */
    public function subscriptionAddPost(SubscriptionRequest $request){
        try {
            $added = $this->subscriptionService->subscriptionAdd($request);
            request()->session()->flash('message-success', "Subscription added successfully" );
            return redirect('admin/subscription-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'Something went wrong, please try again.');
            return redirect('admin/subscription-list');
        }

    }

      /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 02/04/2020
    @FunctionFor: Subscription edit 
    */
    public function subscriptionEdit(Request $request,$id){
        $details = $this->subscriptionService->getDetails($id);
        $activeModule = 'subscription';
        $pageTitle = 'Service Edit';
        return view('Admin.Subscription.add-edit', compact('activeModule','pageTitle','details'));
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 02/04/2020
    @FunctionFor: Subscription add post
    */
    public function subscriptionEditPost(SubscriptionRequest $request){
        try {
            $added = $this->subscriptionService->subscriptionEdit($request);
            request()->session()->flash('message-success', "Subscription updated successfully" );
            return redirect('admin/subscription-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'Something went wrong, please try again.');
            return redirect('admin/subscription-list');
        }

    }


}
