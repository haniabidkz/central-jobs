<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Company\CompanyService;
use App\Repository\Company\CompanyRepository;
use App\Service\StateService;
use App\Service\CountryService;
use App\Service\Company\CompanyReportService;
use App\Service\JobService;
use View;

class CompanyController extends Controller {

    protected $companyService;
    protected $companyRepo;
    protected $stateService;
    protected $countryService;
    protected $companyReportService;
    protected $jobService;

    public function __construct(
        CompanyService $companyService,
        CompanyRepository $companyRepo,
        StateService $stateService,
        CountryService $countryService,
        CompanyReportService $companyReportService,
        JobService $jobService
    )
    {   
        $this->companyService = $companyService;
        $this->companyRepo = $companyRepo;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->companyReportService = $companyReportService;
        $this->jobService = $jobService;
    }


    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/02/2020
    @FunctionFor: Company listing
    */

    public function index(Request $request) {
        $search = $request->all();
        $states = $this->stateService->getStateList(); 
        if(!empty($search) && (isset($search['reset']) && ($search['reset'] == 1))){
            $search = [];
        }elseif(!empty($search) && (isset($search['cntrId']) && ($search['cntrId'] == 14))){
            $search['country'] = 'Austria';
            $search['cntrId'] = 14;
            $states = $this->stateService->getStateById(14); // Austria country id 14
        }
        // elseif(empty($search)){
        //     $search['cntrId'] = 14;
        //     $search['country'] = 'Austria';
        //     $states = $this->stateService->getStateById(14); // Austria country id 14
        // }
        $companies = $this->companyService->fetchList($search);
        $countries = $this->countryService->getCountryList();
        $country_json = json_encode($countries);
        $activeModule = 'company';
        $pageTitle = 'Company List';
        return view('Admin.Company.list', compact('companies', 'activeModule','country_json','states','search','pageTitle'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/02/2020
    @FunctionFor: Company delete
    */
    public function destroy($id)
    {
       
        try{
            $this->companyRepo->removeCompany($id);
            request()->session()->flash('message-success', "Company profile has been deleted successfully" );
            return redirect()->back();
        }catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Company can not be deleted. This company associated with an order or job." );
            return redirect()->back();
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Company change status
    */
    public function changeStatus(Request $request)
    {
        $this->companyRepo->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 19/02/2020
    @FunctionFor: Company view details
    */
    public function viewDetails($id){
        $id = decrypt($id);
        $details = $this->companyService->details($id);
        $activeModule = 'company';
        $pageTitle = 'Company Details';
        return view('Admin.Company.view', compact('details','activeModule','pageTitle'));
    }

      /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/02/2020
    @FunctionFor: get state list
    */
    public function getState(Request $request){
        if($request->ajax()){
            $countryId = $request->input('id');
            $states = $this->stateService->getStateById($countryId);
            $view = View::make('Admin.states', [
                'states'=> $states
            ]);
            $html = $view->render();
            return $html;
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 24/02/2020
    @FunctionFor: Company change status
    */
    public function approveCompany(Request $request)
    {
        $reqData = $request->all();
        $this->companyRepo->approveStatus($reqData);
        if($reqData['status'] == 1){
            request()->session()->flash('message-success', "Company approved successfully" );
        }elseif($reqData['status'] == 2){
            request()->session()->flash('message-success', "Company rejected successfully" );
        }
        echo 1;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 24/02/2020
    @FunctionFor: Company view details
    */
    public function companyGetDetails(Request $request){
        $id = $request->input('id');
        $details = $this->companyService->details($id);
        $view = View::make('Admin.Company.detailsPopup', [
            'details'=> $details
        ]);
        $html = $view->render();
        return $html;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 26/02/2020
    @FunctionFor: Company view details
    */
    public function companyReportList(Request $request){
        $id = $request->input('id');
        $list = $this->companyReportService->fetchList($id);
        $list = json_encode($list);
        return $list;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 26/02/2020
    @FunctionFor: Company view job list
    */
    public function jobList(Request $request,$id){
        $id = decrypt($id);
        $search = $request['search'];
        if($search == null){
            $search = '';
        }
        $jobs = $this->jobService->getAllJobByUser($search,$id);
        $activeModule = 'company';
        $pageTitle = 'Company Job List';
        return view('Admin.Company.jobList', compact('jobs', 'activeModule','search','id','pageTitle'));
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 26/02/2020
    @FunctionFor: Company view job list
    */
    public function companyReportAllList(Request $request,$id){
        $list = $this->companyReportService->fetchListArray($id);
        $activeModule = 'company';
        $pageTitle = 'Company Report List';
        return view('Admin.Company.reportList', compact('list', 'activeModule','pageTitle'));
    }
}
