<?php
namespace App\Service;
use App\Repository\UserRepository;
use App\Repository\JobRepository;
use Illuminate\Support\Facades\Auth;

class JobService {
    
    protected $jobRepo;
    protected $userRepo;

    /**
     * @param CompanyRepository $candidateRepo reference to ambasadorRepo
     * @param UserRepository $userRepo reference to userRepo
     * 
     */
    public function __construct(
        JobRepository $jobRepo,
        UserRepository $userRepo
    ) {
        $this->jobRepo = $jobRepo;
        $this->userRepo = $userRepo;
    }

    /** 
     * Get All Candidate List
    */
    public function fetchList($request="") {
        return $this->jobRepo->get($request);
    }

    /** 
     * Get Details of cms page with ID
     * @param array $id
    */
    public function details($id){
        return $this->jobRepo->findOne([ ["id",$id] ]);
    }

    /** 
     * Get country list
     * @param array $id
    */
    public function getCountryList(){
        return $this->jobRepo->findAllCountryList();
    }

    /** 
     * Get state list
     * @param array $id
    */
    public function getStateList(){
        return $this->jobRepo->findAllStateList();
    }

     /** 
     * Get state list
     * @param array $id
    */
    public function getStateById($id=''){
        return $this->jobRepo->getStateListById($id);
    }

    /** 
     * Get country list
     * @param array $id
    */
    public function countryWithsearch(){
        return $this->jobRepo->searchCountryList();
    }
    /** 
     * job update
     * @param array $id job id
    */
    public function updateDetails($id='',$data=''){
        if(isset($data['cntrId']) && $data['cntrId'] != ''){
            //$data['country_id'] = $data['cntrId'];
            $data['country_id'] = 14;
            unset($data['cntrId']);
            unset($data['_token']);
            //dd($data);
        }
        if(isset($data['applied_by']) && $data['applied_by'] == 1){
            $data['website_link'] = '';
        }
        //dd($data);
        return $this->jobRepo->updateDetails($id,$data);
    }
    /** 
     * job update
     * @param array $id job id
    */
    public function addDetails($data=''){
        $data['country_id'] = $data['cntrId'];
        unset($data['cntrId']);
        unset($data['_token']);
        if($data['applied_by'] == 1){
            $data['website_link'] = '';
        }
        return $this->jobRepo->addDetails($data);
    }

    /**
     * Job Delete
     * @param array $id job id
     */
    public function deleteJob($id)
    {
        return $this->jobRepo->removeJob($id, true);
    }

    public function deleteClosedAppliedJobs(){
        return $this->jobRepo->removeClosedAppliedJobs();
    }
    /** 
     * user list who applied for this job
     * @param array $id
    */
    public function getAllUserApplied($jobId='',$search=''){
        return $this->jobRepo->getAllUserApplied($jobId,$search);
    }

     /** 
     * user list who applied for this job
     * @param array $id
    */
    public function getAllJobByUser($search='',$userId=''){
        return $this->jobRepo->getAllJobByUser($search,$userId);
    }
    
}