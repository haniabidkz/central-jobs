<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\PostService;
use App\Repository\PostRepository;
use App\Repository\ReportedPostRepository;
use App\Service\StateService;
use App\Service\CountryService;
use App\Service\ReportedPostService;
use View;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\PostRequest;

class PostController extends Controller {

    protected $postService;
    protected $postRepo;
    protected $reportedPostRepo;
    protected $stateService;
    protected $countryService;
    protected $reportedPostService;


    public function __construct(
        PostService $postService,
        PostRepository $postRepo,
        ReportedPostRepository $reportedPostRepo,
        StateService $stateService,
        CountryService $countryService,
        ReportedPostService $reportedPostService
    )
    {   
        $this->postService = $postService;
        $this->postRepo = $postRepo;
        $this->reportedPostRepo = $reportedPostRepo;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->reportedPostService = $reportedPostService;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 27/02/2020
    @FunctionFor: All Post listing
    */

    public function index(Request $request) {
        $posts = $this->postService->fetchList();
        $activeModule = 'post';
        $pageTitle = 'Post List';
        return view('Admin.postList', compact('posts', 'activeModule',"pageTitle"));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 27/02/2020
    @FunctionFor: Post detail
    */
    public function postView(Request $request,$id){
        $id = decrypt($id);
        $details = $this->postService->details($id);
        $activeModule = 'post';
        $pageTitle = 'Post Details';
        return view('Admin.postView', compact('details','activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: post edit
    */
    public function postEdit(Request $request,$id) {
        $id = decrypt($request['id']);
        $details = $this->postService->details($id);
        $countries = $this->countryService->getCountryList();
        $states = $this->stateService->getStateById(14); // Austria country id 14
        $postCategory = $this->postRepo->getCategoryList();
        $skills = $this->postRepo->getSkillList();
        $country_json = json_encode($countries);
        $companyList = $this->postRepo->getCompanyListArray();
        $activeModule = 'post';
        $pageTitle = 'Post Edit';
        return view('Admin.postEdit', compact('details', 'activeModule','countries','states','country_json','postCategory','skills','companyList','pageTitle'));
    }
      /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: post edit
    */

    public function postEditPost(PostRequest $request,$id) {
        $id = decrypt($id);
        $data = $this->postService->updateDetails($id,$request);
        request()->session()->flash('message-success', "Post updated successfully" );
        return redirect('admin/post-list');
    }


     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 28/02/2020
    @FunctionFor: Post add view
    */
    public function postAdd(Request $request){
        if(isset($request['job'])){
            $type = $request['job'];
            $activeModule = 'job';
            $pageTitle = 'Job Add';
        }else{
            $type = '';
            $activeModule = 'post';
            $pageTitle = 'Post Add';
        }
        //dd($request['job']);
        $postCategory = $this->postRepo->getCategoryList();
        $countries = $this->countryService->getCountryList();
        $states = $this->stateService->getStateById(14); // Austria country id 14
        $skills = $this->postRepo->getSkillList();
        $country_json = json_encode($countries);
        $companyList = $this->postRepo->getCompanyListArray();
        
        return view('Admin.postEdit', compact('activeModule','countries','states','country_json','postCategory','skills','type','companyList','pageTitle'));
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 28/02/2020
    @FunctionFor: Post add to db
    */
    public function postAddPost(PostRequest $request){
        try {
            $activeModule = 'post';
            $title        = "Post Add";  
            $added = $this->postService->postAdd($request);
            request()->session()->flash('message-success', "Job posted successfully" );
            if($request['category_id']==1){
                return redirect('admin/job-list');
            }else{
                return redirect('admin/post-list');
            }
            
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/post-list');
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/03/2020
    @FunctionFor: All Reported Post listing
    */

    public function reportedPostList(Request $request) {
        $conditions = [['status',0],['type','post']];
        $with = 'post';
        $reportedPosts = $this->reportedPostService->fetchList($conditions,$with);
        $activeModule = 'reportedpost';
        $pageTitle = 'Reported Post List';
        return view('Admin.reportedPostList', compact('reportedPosts', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/03/2020
    @FunctionFor: All Reported listing for the post
    */

    public function getReportDetails(Request $request) {
        $id = $request->input('id');
        $details = $this->reportedPostService->details($id);
        $details = json_encode($details);
        return $details;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function postChangeStatus(Request $request)
    {
        $result = $this->postRepo->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/03/2020
    @FunctionFor: All Reported listing for the post
    */

    public function viewReportDetails(Request $request) {
       $id = decrypt($request['id']);
       $details = $this->reportedPostService->viewDetails($id);
       $activeModule = 'reportedpost';
       $pageTitle = 'Reported Post Details';
       //echo '<pre>'; print_r($details);exit;
       return view('Admin.viewReportDetails', compact('activeModule','details','id','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function reportedPostAbuse(Request $request)
    {
        $result = $this->reportedPostRepo->reportedPostAbuse($request->all());
        request()->session()->flash('message-success', "Report marked as abusive sucessfully." );
        echo $result;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function reportedPostIgnore(Request $request)
    {
        $result = $this->reportedPostRepo->reportedPostIgnore($request->all());
        request()->session()->flash('message-success', "Report has been ignored successfully." );
        echo $result;
    }


    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 16/03/2020
    @FunctionFor: All Reported comment listing
    */

    public function reportedCommentList(Request $request) {
        $conditions = [['status',0],['type','post_comment']];
        $with = 'comment';
        $reportedComments = $this->reportedPostService->fetchList($conditions,$with);
        $activeModule = 'reportedcomment';
        $pageTitle = 'Comment List';
        return view('Admin.reportedCommentList', compact('reportedComments', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 03/03/2020
    @FunctionFor: All Reported listing for the post
    */

    public function viewCommentReportDetails(Request $request) {
        $id = decrypt($request['id']);
        $details = $this->reportedPostService->viewCommentDetails($id);
        $activeModule = 'reportedcomment';
        $pageTitle = 'Comment Details';
        //echo '<pre>'; print_r($details);exit;
        return view('Admin.viewCommentReportDetails', compact('activeModule','details','id','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function reportedCommentAbuse(Request $request)
    {
        $result = $this->reportedPostRepo->reportedCommentAbuse($request->all());
        request()->session()->flash('message-success', "Report marked as abusive sucessfully." );
        echo $result;
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 11/02/2020
    @FunctionFor: Candidate change status
    */
    public function reportedCommentIgnore(Request $request)
    {
        $result = $this->reportedPostRepo->reportedCommentIgnore($request->all());
        request()->session()->flash('message-success', "Report has been ignored successfully." );
        echo $result;
    }
}
