<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\JobPost;
use App\Http\Model\Post;
use App\Service\JobService;
use App\Repository\JobRepository;
use App\Repository\PostRepository;
use App\Service\Company\CompanyService;
use App\Service\Candidate\CandidateService;
use App\Service\StateService;
use App\Service\CountryService;
use View;
use App\Http\Requests\Admin\JobEditRequest;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    protected $jobService;
    protected $jobRepo;
    protected $postRepo;
    protected $companyService;
    protected $stateService;
    protected $candidateService;
    protected $countryService;

    public function __construct(
        JobService $jobService,
        PostRepository $postRepo,
        JobRepository $jobRepo,
        CompanyService $companyService,
        StateService $stateService,
        CandidateService $candidateService,
        CountryService $countryService
    ) {
        $this->jobService = $jobService;
        $this->jobRepo = $jobRepo;
        $this->postRepo = $postRepo;
        $this->companyService = $companyService;
        $this->stateService = $stateService;
        $this->candidateService = $candidateService;
        $this->countryService = $countryService;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job listing
    */

    public function jobs(Request $request)
    {

        $pageTitle = 'Jobs';

        $jobs = JobPost::whereIn('job_status', [0,3])
            ->with(['user'])
            ->paginate(env('ADMIN_PAGINATION_LIMIT'));


        $countries = $this->countryService->getCountryList();
        $companyList = $this->postRepo->getCompanyList();
        $company_json = json_encode($companyList);
        $country_json = json_encode($countries);
        $activeModule = 'jobs';

        return view('Admin.jobs', compact('jobs', 'pageTitle', 'company_json', 'country_json', 'activeModule'));
    }

    public function acceptJob(Request $request, $id)
    {

        $job = JobPost::where('id', $id)->first();
        $job->status = 1;
        $job->job_status = 1;
        $job->save();
        $this->sendApprovalEmail($job, true);
        request()->session()->flash('message-success', "Job has been accepted successfully!");
        return redirect()->back();
    }

    public function rejectJob(Request $request, $id)
    {

        try {
            $job =  JobPost::find($id);
            $job->status = 0;
            $job->job_status = 3;
            $job->save();
            $this->sendApprovalEmail($job, false);
            request()->session()->flash('message-success', "Job has been rejected successfully");
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Job can not be rejected. This job associated with an user.");
            return redirect()->back();
        }
    }

    private function sendApprovalEmail($job, $approved)
    {
        $emailType = $approved ? 'accepted' : 'rejected';

        $statusMap = [
            'accepted' => [
                'subject' => 'Job Post Approved: ' . $job->title,
                'template' => 'email.jobAccepted'
            ],
            'rejected' => [
                'subject' => 'Job Post Rejected: ' . $job->title,
                'template' => 'email.jobRejected'
            ]
        ];

        Mail::send($statusMap[$emailType]['template'], [
            'job' => $job,
            'status' => $job->status,
            'job_status' => $job->job_status
        ], function ($message) use ($job, $statusMap, $emailType) {
            $message->to($job->user->email)
                ->subject($statusMap[$emailType]['subject']);
        });
    }
    public function jobDetail(Request $request, $id)
    {
        $id = decrypt($id);
        $details = $this->jobService->details($id);
        $activeModule = 'job';
        $pageTitle = 'Job Details';
        return view('Admin.jobDetail', compact('details', 'activeModule', 'pageTitle'));
    }
    public function deleteJob(Request $request, $id)
    {
        try {

            $job = $this->jobRepo->removeJob($id);
            request()->session()->flash('message-success', "Job has been deleted successfully");
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Job can not be deleted. This job associated with an user.");
            return redirect()->back();
        }
    }
    public function index(Request $request)
    {
        $search = $request->all();
        //dd($search);
        $states = $this->stateService->getStateList();
        if (!empty($search) && (isset($search['reset']) && ($search['reset'] == 1))) {
            $search = [];
        } elseif (!empty($search) && (isset($search['cntrId']) && ($search['cntrId'] == 14))) {
            $search['country'] = 'Austria';
            $search['cntrId'] = 14;
            $states = $this->stateService->getStateById(14); // Austria country id 14
        }
        // elseif(empty($search)){
        //     $search['cntrId'] = 14;
        //     $search['country'] = 'Austria';
        //     $states = $this->stateService->getStateById(14); // Austria country id 14
        // }
        $jobs = $this->jobService->fetchList($request);
        $countries = $this->countryService->getCountryList();
        $companyList = $this->postRepo->getCompanyList();
        $company_json = json_encode($companyList);
        $country_json = json_encode($countries);
        $activeModule = 'job';
        $pageTitle = 'Job List';
        return view('Admin.jobList', compact('jobs', 'activeModule', 'pageTitle', 'states', 'countries', 'companyList', 'company_json', 'country_json', 'search'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 13/02/2020
    @FunctionFor: Job delete
    */
    public function destroy($id)
    {
        try {

            $job = $this->jobRepo->removeJob($id);
            request()->session()->flash('message-success', "Job has been deleted successfully");
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Job can not be deleted. This job associated with an user.");
            return redirect()->back();
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job change status
    */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $result = $this->jobRepo->changeStatus($id, $status);
        request()->session()->flash('message-success', "Status changed successfully");
        echo 1;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job edit
    */
    public function jobAdd(Request $request)
    {
        //$details = $this->jobService->details($id);
        $countries = $this->jobService->getCountryList();
        $states = $this->stateService->getStateById(14); // Austria country id 14
        $country_json = json_encode($countries);
        $skills = $this->postRepo->getSkillList();
        $companyList = $this->postRepo->getCompanyListArray();
        $seniority = $this->companyService->getSeniorityList();
        $employment = $this->companyService->getEmploymentList();
        $language = $this->companyService->getLanguageList();
        $activeModule = 'job';
        $pageTitle = 'Job Add';
        return view('Admin.jobEdit', compact('details', 'countries', 'country_json', 'states', 'activeModule', 'skills', 'companyList', 'pageTitle', 'seniority', 'employment', 'language'));
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 17/03/2020
    @FunctionFor: Job edit post
    */
    public function jobAddPost(JobEditRequest $request)
    {
        $this->jobService->addDetails($request->all());
        request()->session()->flash('message-success', "Job added successfully");
        return redirect('admin/job-list');
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job edit
    */
    public function jobEdit(Request $request, $id)
    {
        $id = decrypt($id);
        $details = $this->jobService->details($id);
        //dd($details);
        $countries = $this->jobService->getCountryList();
        $selectedCountry = $details['country']['id']; // Austria country id 14
        $states = $this->stateService->getStateById($selectedCountry); // Austria country id 14
        $country_json = json_encode($countries);
        $skills = $this->postRepo->getSkillList();
        $companyList = $this->postRepo->getCompanyListArray();
        $seniority = $this->companyService->getSeniorityList();
        $employment = $this->companyService->getEmploymentList();
        $language = $this->companyService->getLanguageList();
        $activeModule = 'job';
        $pageTitle = 'Job Edit';
        return view('Admin.jobEdit', compact('details', 'countries', 'country_json', 'states', 'activeModule', 'skills', 'companyList', 'pageTitle', 'seniority', 'employment', 'language', 'id'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 17/03/2020
    @FunctionFor: Job edit post
    */
    public function jobEditPost(JobEditRequest $request, $id)
    {
        $id = decrypt($id);
        $this->jobService->updateDetails($id, $request->all());
        request()->session()->flash('message-success', "Job updated successfully");
        return redirect('admin/job-list');
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job edit
    */
    public function jobView(Request $request, $id)
    {
        $id = decrypt($id);
        $details = $this->jobService->details($id);
        $activeModule = 'job';
        $pageTitle = 'Job Details';
        return view('Admin.jobView', compact('details', 'activeModule', 'pageTitle'));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 12/02/2020
    @FunctionFor: Job edit
    */
    public function getState(Request $request)
    {
        if ($request->ajax()) {
            $countryId = $request->input('id');
            $states = $this->jobService->getStateById($countryId);
            $view = View::make('Admin.states', [
                'states' => $states
            ]);
            $html = $view->render();
            return $html;
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 17/02/2020
    @FunctionFor: Job applied by users
    */
    public function usersApplied($jobId, Request $request)
    {
        $search = $request['search'];
        if ($search == null) {
            $search = '';
        }
        $jobId = decrypt($jobId);
        $users = $this->jobService->getAllUserApplied($jobId, $search);
        $activeModule = 'job';
        $pageTitle = 'Candidate Applied For Jobs';
        return view('Admin.jobAppliedUserList', compact('users', 'activeModule', 'jobId', 'search', 'pageTitle'));
    }
}
