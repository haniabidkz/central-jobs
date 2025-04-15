<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Candidate\CandidateService;
use App\Repository\Candidate\CandidateRepository;
use App\Service\StateService;
use App\Service\CountryService;
use App\Repository\PostRepository;
use View;

class CandidateController extends Controller {

    protected $candidateService;
    protected $candidateRepo;
    protected $stateService;
    protected $countryService;
    protected $postRepo;

    public function __construct(
        CandidateService $candidateService,
        CandidateRepository $candidateRepo,
        StateService $stateService,
        PostRepository $postRepo,
        CountryService $countryService
    )
    {   
        $this->candidateService = $candidateService;
        $this->candidateRepo = $candidateRepo;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->postRepo = $postRepo;
    }


    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/02/2020
    @FunctionFor: Candidate listing
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
        $candidates = $this->candidateService->fetchList($search);
        $countries = $this->countryService->getCountryList();
        $companyList = $this->postRepo->getUserProfInfoArray();
        $company_json = json_encode($companyList);
        $country_json = json_encode($countries);
        $activeModule = 'candidate';
        $pageTitle = 'Candidate List';
        return view('Admin.Candidate.list', compact('companyList','candidates', 'activeModule','country_json','states','search','pageTitle','company_json'));
        
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/02/2020
    @FunctionFor: Candidate delete
    */
    public function destroy($id)
    {
        try{
            $candidate = $this->candidateRepo->removeCandidate($id);
            request()->session()->flash('message-success', "Candidate profile has been deleted successfully" );
            return redirect()->back();
        }
        catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Candidate can not be deleted. This candidate associated with a job or order." );
            return redirect()->back();
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function changeStatus(Request $request)
    {
        $result = $this->candidateRepo->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 19/02/2020
    @FunctionFor: Candidate view details
    */
    public function viewDetails($id){
        $id = decrypt($id);
        $details = $this->candidateService->getDetails($id);
        //dd($details);
        $activeModule = 'candidate';
        $pageTitle = 'Candidate Details';
        return view('Admin.Candidate.view', compact('details','activeModule','pageTitle'));
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

}
