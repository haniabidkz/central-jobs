<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\AdvertisementService;

class AdvertisementController extends Controller {

    protected $advertiseService;

    public function __construct(
        AdvertisementService $advertiseService
    )
    {   
        $this->advertiseService = $advertiseService;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: All Advertisement listing
    */

    public function index(Request $request) {
        $advertises = $this->advertiseService->fetchList();
        $activeModule = 'advertise';
        $pageTitle = 'Advertisement List';
        return view('Admin.Advertisement.list', compact('advertises', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category add view
    */
    public function add(Request $request){
        $activeModule = 'advertise';
        $pageTitle = 'Advertisement Add';
        return view('Admin.Advertisement.add', compact('activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category add to db
    */
    public function addPost(Request $request){
        try {
            $activeModule = 'advertise';
            $title        = "Advertisement Add";  
            $added = $this->advertiseService->addAdvertisement($request);
            request()->session()->flash('message-success', "Advertisement added successfully." );
            return redirect('admin/advertise-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/advertise-list');
        }
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category edit
    */
    public function edit(Request $request, $id) {
        $id = decrypt($request['id']);
        $details = $this->advertiseService->details($id);
        $activeModule = 'advertise';
        $pageTitle = 'Advertisement Add';
        return view('Admin.Advertisement.add', compact('details', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category edit post
    */
    public function editPost(Request $request){
        $data = $this->advertiseService->updateDetails($request);
        request()->session()->flash('message-success', "Advertisement updated successfully");
        return redirect('admin/advertise-list');
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: category change status
    */
    public function changeStatus(Request $request)
    {
        $result = $this->advertiseService->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: category delete
    */
    public function advertiseDestroy($id)
    {
        $this->advertiseService->advertiseDestroy($id);
        request()->session()->flash('message-success', "Advertise has been deleted successfully" );
        return redirect()->back();
    }

}
