<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\BestAdvertisementService;

class BestAdvertisementController extends Controller {

    protected $bestAdvertiseService;

    public function __construct(
        BestAdvertisementService $bestAdvertiseService
    )
    {   
        $this->bestAdvertiseService = $bestAdvertiseService;
    }

    /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: All BestAdvertisement listing
    */
    public function index(Request $request) {
        $advertises = $this->bestAdvertiseService->fetchList();
        $activeModule = 'bestAdvertise';
        $pageTitle = 'Best Advertisement List';
        return view('Admin.BestAdvertisement.list', compact('advertises', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category add view
    */
    public function add(Request $request){
        $activeModule = 'bestAdvertise';
        $pageTitle = 'Best Advertisement Add';
        return view('Admin.BestAdvertisement.add', compact('activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category add to db
    */
    public function addPost(Request $request){
        try {
            $activeModule = 'bestAdvertise';
            $title        = "Best Advertisement Add";  
            $added = $this->bestAdvertiseService->add($request);
            request()->session()->flash('message-success', "Best Advertisement added successfully." );
            return redirect('admin/best-advertise-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/best-advertise-list');
        }
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category edit
    */
    public function edit(Request $request, $id) {
        $id = decrypt($request['id']);
        $details = $this->bestAdvertiseService->details($id);
        $activeModule = 'bestAdvertise';
        $pageTitle = 'BestAdvertisement Add';
        return view('Admin.BestAdvertisement.add', compact('details', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: Category edit post
    */
    public function editPost(Request $request){
        $data = $this->bestAdvertiseService->updateDetails($request);
        request()->session()->flash('message-success', "BestAdvertisement updated successfully");
        return redirect('admin/best-advertise-list');
    }
     /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: category change status
    */
    public function changeStatus(Request $request)
    {
        $result = $this->bestAdvertiseService->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Pragya Datta
    @Date: 11/04/2021
    @FunctionFor: category delete
    */
    public function destroy($id)
    {
        $this->bestAdvertiseService->destroy($id);
        request()->session()->flash('message-success', "Advertise has been deleted successfully" );
        return redirect()->back();
    }

}
