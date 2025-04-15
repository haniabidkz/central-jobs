<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Service\SubscriptionService;
use App\Http\Requests\Order;
use Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $subscriptionService;

    public function __construct(OrderService $orderService,SubscriptionService $subscriptionService)
    {   
        $this->orderService = $orderService;
        $this->subscriptionService = $subscriptionService;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Order list
    */
    public function index(Request $request)
    {        
        $search = $request->all();
        $orders = $this->orderService->getAllList($request);       
        $activeModule = "order";
        $pageTitle = 'Order List';
        return view('Admin.Order.list', compact("orders","activeModule",'search','pageTitle'));
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Order details popup
    */
    public function viewOrderDetails(Request $request){
        $data = $request->all(); 
        $details = $this->orderService->getDetails($data);
        $details = json_encode($details);
        return $details;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 19/03/2020
    @FunctionFor: Order status change
    */
    public function OrderChangeStatus(Request $request){
        $data = $request->all();         
        $order = $this->orderService->updateOrder($data);
        if($order == true){
            request()->session()->flash('message-success', "Order has been closed successfully" );
            return 1;
        }else{
            request()->session()->flash('message-error', "Something went wrong, please try again." );
            return 0;
        }
        
    }
    /**
     * Function to add new services or Subscription
     * @return View
     */
    public function addSubscriptionOrder()
    {       
        $details = [];   
        $activeModule = "addSubsOrder";
        $subscriptions = $this->subscriptionService->getActiveSubscriptions();
        $pageTitle = 'Add Subscription Order';
        return view('Admin.Order.addSubscriptionOrder', compact("pageTitle","details","activeModule","subscriptions"));
    }
    /**
     * Function to edit recent posted subscription info
     * @return View
     */
    public function editSubscriptionOrder($id)
    {
        $data['id'] = decrypt($id);
        $activeModule = "addSubsOrder";
        $details = $this->orderService->getDetails($data);
        $subscriptions = $this->subscriptionService->getActiveSubscriptions();
        $pageTitle = 'Edit Subscription Order';
        return view('Admin.Order.addSubscriptionOrder', compact("pageTitle","details","activeModule","subscriptions"));
    }
    /**
     * Function to store subscription order information
     * @return Void
     */
    public function storeSubscriptionInfo(Order $orderRequested)
    {        
        try {
            $this->orderService->addSubscriptionOrderInfo($orderRequested->all());
            request()->session()->flash('message-success', 'Subscription order information saved successfully and payment link sent to the user through email.');
            return redirect('admin/order-list');
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Something happened wrong.Please try again.');
            return redirect('admin/order-list');
        }
        
    }
    /**
     * Function to update suscription
     * @return Void
     */
    public function updateSubscriptionInfo(Order $orderRequested)
    {
        try {
            $this->orderService->editOrder($orderRequested->all());
            request()->session()->flash('message-success', 'Subscription order information update successfully.');
            return redirect('admin/order-list');
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Something happened wrong.Please try again.');
            return redirect('admin/order-list');
        }

    }
    /**
     * function to delete order placed status
     * @return View
     */
    public function destroy($id)
    {
        try {
            $this->orderService->deleteOrder($id);
            request()->session()->flash('message-success', 'Subscription order information deleted successfully.');           
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Something happened wrong.Please try again.');            
        }
        return redirect('admin/order-list');
    }
}
