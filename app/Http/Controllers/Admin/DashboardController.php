<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Candidate\CandidateService;
use App\Repository\Candidate\CandidateRepository;
use App\Service\Company\CompanyService;
use App\Repository\Company\CompanyRepository;
use App\Repository\JobRepository;
use App\Repository\TrainingRepository;
use App\Service\ReportedPostService;
use App\Service\JobService;
use Carbon\Carbon;
use App\Service\Company\CompanyReportService;



class DashboardController extends Controller {

    protected $candidateService;
    protected $companyService;
    protected $jobService;
    protected $candidateRepo;
    protected $companyRepo;
    protected $jobRepo;
    protected $trainingRepo;
    protected $reportedPostService;
    protected $companyReportService;
    public function __construct(
      //  TrainingRepository $trainingRepo,
        CandidateService $candidateService,
        CompanyService $companyService,
        JobService $jobService,
        CandidateRepository $candidateRepo,
        CompanyRepository $companyRepo,
        JobRepository $jobRepo,
        TrainingRepository $trainingRepo,
        ReportedPostService $reportedPostService,
        CompanyReportService $companyReportService
      
    )
    {   
        $this->candidateService = $candidateService;
        $this->companyService = $companyService;
        $this->jobService = $jobService;
        $this->candidateRepo = $candidateRepo;
        $this->companyRepo = $companyRepo;
        $this->jobRepo = $jobRepo;
        $this->trainingRepo = $trainingRepo;
        $this->reportedPostService = $reportedPostService;
        $this->companyReportService = $companyReportService;
      
    }


    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/02/2020
    @FunctionFor: Admin Dashboard 
    */

    public function index() {

        //training videos
        $condTrngVideo = [['status',1]];
        
        $totalTrainingVideos = $this->trainingRepo->getCountTrainingVideos($condTrngVideo);
        //Reported Comment 
        $conditions = [['status',0],['type','post_comment']];
        $with = 'comment';
        $reportedComments = $this->reportedPostService->fetchListAll($conditions,$with);
        $totalReportedCommentCount  = count($reportedComments);

        //Reported Post
        $conditionsPost = [['status',0],['type','post']];
        $withPost = 'post';
        $reportedPosts = $this->reportedPostService->fetchListAll($conditionsPost,$withPost);
        $totalReportedPostCount  = count($reportedPosts); 

        // candidates
        $conditionTotal = [['user_type',2]];
        $totalCandidates = $this->candidateRepo->getCandidateCount($conditionTotal);

        $condition = [ [ 'status',1 ],['user_type',2]];
        $activeCandidate = $this->candidateRepo->getCandidateCount($condition);
        $condition1 = [ [ 'status',0 ],['user_type',2]];
        $blockedCandidate = $this->candidateRepo->getCandidateCount($condition1);
        $condition_deactivated1 = [ [ 'status',2 ],['user_type',2]];
        $deactivatedCandidate = $this->candidateRepo->getCandidateCount($condition_deactivated1);
        $blockedCandidate = $blockedCandidate + $deactivatedCandidate; 
        // companies
        $conditionTotalCompany = [['user_type',3]];
        $totalCompanies = $this->companyRepo->getCandidateCount($conditionTotalCompany);

        $condition2 = [ [ 'status',1 ],['user_type',3]];
        $activeCompany = $this->companyRepo->getCandidateCount($condition2);
        $condition3 = [ [ 'status',0 ],['user_type',3]];
        $blockedCompany = $this->companyRepo->getCandidateCount($condition3);
        $condition_deactivated2 = [ [ 'status',2 ],['user_type',3]];
        $deactivatedCompany = $this->companyRepo->getCandidateCount($condition_deactivated2);
        $blockedCompany = $blockedCompany + $deactivatedCompany;

        // Pending Approval
        $totalPendingCompany = $this->companyRepo->getPendingCompanyCount();
        //Reported Employer
        $reportedEmployer = $this->companyReportService->fetchReportedList();
        $reportedEmployerCount = count($reportedEmployer);

        // jobs
        // $jobs = $this->jobService->fetchList();
        // $totalJobs = count($jobs);
        $condition_job = [['category_id',1]];
        $totalJobs = $this->jobRepo->getJobCount($condition_job);
        $today = date("Y-m-d");
        $today = Carbon::parse($today)
                      ->startOfDay()        // 2018-09-29 00:00:00.000000
                      ->toDateTimeString(); // 2018-09-29 00:00:00
        //   $to = Carbon::parse($filterData['to'])
        //           ->endOfDay()          // 2018-09-29 23:59:59.000000
        //           ->toDateTimeString(); // 2018-09-29 23:59:59

        
        $condition6 = [['start_date','<=',$today],['end_date','>=',$today],['category_id',1]];
        $ongoingJob = $this->jobRepo->getJobCount($condition6);
        
        $condition5 = [['start_date','>',$today],['category_id',1]];
        $scheduledJob = $this->jobRepo->getJobCount($condition5);

        $condition4 = [['end_date','<',$today],['category_id',1]];
        $closedJob = $this->jobRepo->getJobCount($condition4);

        //YEARLY DATA
        $yearly = 2020;
        $currentYear = date("Y");
        $barChart = [];
        for($i = $yearly ; $i <= $currentYear ; $i++){                
                $barChartData['year'] = $i;
                $currentYear =  $i.'-01-01 00:00:00';
                $currentYearEnd = $i.'-12-31 23:59:59';
               
                $compCond = [['created_at','>=',$currentYear],['created_at','<=',$currentYearEnd],['user_type',3]];
                $candCond = [['created_at','>=',$currentYear],['created_at','<=',$currentYearEnd],['user_type',2]];
                $jobCond = [['start_date','>=',$currentYear],['start_date','<=',$currentYearEnd],['category_id',1]];
                $barChartData['company'] = $this->companyRepo->getCompanyCount($compCond);
                $barChartData['candidates'] = $this->candidateRepo->getCandidateCount($candCond);
                $barChartData['jobs'] = $this->jobRepo->getJobCount($jobCond);
                
                $barChart[] = $barChartData;
        }
        $barChartData = [];
        // $barChartData['year'] = 2019;
        // $barChartData['company'] = 1111;
        // $barChartData['candidates'] = 1000;
        // $barChartData['jobs'] = 500;
        // $barChart[] = $barChartData;
        $dataChart = json_encode($barChart);
        // print_r($dataChart);
        // die();
        $pageTitle = 'Dashboard';
        return view('Admin.dashboard',compact('totalTrainingVideos','dataChart','totalCandidates','activeCandidate','blockedCandidate','totalCompanies','activeCompany','blockedCompany','totalJobs','ongoingJob','scheduledJob','closedJob','pageTitle','totalReportedCommentCount','totalReportedPostCount','totalPendingCompany','reportedEmployerCount'));
    }


}
