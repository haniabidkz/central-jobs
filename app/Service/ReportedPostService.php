<?php
namespace App\Service;
use App\Repository\UserRepository;
use App\Repository\ReportedPostRepository;
use Illuminate\Support\Facades\Auth;
use App\Repository\CommonRepository;
use App\Http\Model\ReportedPost;

class ReportedPostService {
    
    protected $reportedPostRepo;
    protected $userRepo;
    protected $commentRepository;

    /**
     * @param ReportedPostRepository $candidateRepo reference to reportedPostRepo
     * @param UserRepository $userRepo reference to userRepo
     */
    public function __construct(
        ReportedPostRepository $reportedPostRepo,
        UserRepository $userRepo,
        ReportedPost $model
    ) {
        $this->reportedPostRepo = $reportedPostRepo;
        $this->userRepo = $userRepo;
        $this->commentRepository = new CommonRepository($model);
    }

    /** 
     * Get All reported post List
    */
    public function fetchList($conditions='',$with='') {
        return $this->reportedPostRepo->get($conditions,$with);
    }

    /** 
     * Get All reported post List
    */
    public function fetchListAll($conditions='',$with='') {
        return $this->reportedPostRepo->getAll($conditions,$with);
    }

    /** 
     * Get All report details List
    */
    public function details($id='') {
        return $this->reportedPostRepo->details($id);
    }

    /** 
     * Get All report details List
    */
    public function viewDetails($id='') {
        return $this->reportedPostRepo->viewDetails($id);
    }
    
    public function viewCommentDetails($id){
        return $this->reportedPostRepo->viewCommentDetails($id);
    }
    
}